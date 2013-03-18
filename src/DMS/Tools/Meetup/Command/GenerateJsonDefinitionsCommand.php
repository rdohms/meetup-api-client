<?php

namespace DMS\Tools\Meetup\Command;

use DOMElement;
use Exception;
use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DomCrawler\Crawler;

class GenerateJsonDefinitionsCommand extends Command
{
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;

    /**
     * @var DialogHelper
     */
    protected $dialog;

    /**
     * @var array
     */
    protected $definitions = array();

    /**
     * @var array
     */
    protected $apis = array();

    protected function configure()
    {
        $this
            ->setName('dms:meetup:generate-json')
            ->setDescription(
                'Parses online documentation into Operation definitions in json for Guzzle asking for extra input'
            )
            ->setDefinition(
                array(
                    new InputArgument('dir', InputArgument::REQUIRED, 'Directory where docs have been downloaded to.'),
                )
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        $this->dialog = $this->getHelperSet()->get('dialog');

        $this->parseDocuments();
    }

    protected function getFileIterator()
    {
        $directory = $this->input->getArgument('dir');

        return new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    }

    protected function parseDocuments()
    {
        $this->apis = array(
            'v2' => array(),
            'ew' => array(),
            'v1' => array(),
        );

        foreach ($this->getFileIterator() as $file) {

            $this->parseDocumentationPage($file);

        }

        $this->output->writeln("All Operations parsed, dumping JSON configuration:");

        foreach ($this->apis as $key => $value) {
            $this->output->writeln(sprintf("<info>API %s</info>", $key));
            $this->output->writeln(json_encode($value));
            $this->output->writeln('');
        }


    }

    /**
     * Parses Documentation Page
     *
     * @param $file
     * @throws \OutOfBoundsException
     */
    protected function parseDocumentationPage($file)
    {
        try {

            /** @var $file SplFileInfo */
            if ($file->getExtension() !== 'html') {
                throw new \OutOfBoundsException("Not HTML.");
            }

            $crawler = new Crawler(file_get_contents($file->getRealPath()));

            // Check is Doc page
            if ($crawler->filter('#method-info')->count() == 0) {
                throw new \OutOfBoundsException("Not Documentation File.");
            }

            // Check if is not deprecated
            if ($crawler->filter('.deprecation-warning')->count() > 0) {
                throw new \OutOfBoundsException('Deprecated.');
            }

            $this->output->writeln("Parsing: " . $file->getPathname());
            $this->getMethodDefinitions($crawler);

        } catch (\OutOfBoundsException $e) {
            $this->output->writeln(
                sprintf(
                    '<error>SKIPPED:</error> <info>%s</info> because <info>%s</info>',
                    $file->getPathname(),
                    $e->getMessage()
                )
            );
        } catch (InvalidArgumentException $e) {
            $this->output->writeln(
                sprintf(
                    '<error>ERROR:</error> <info>%s</info> with <info>%s</info> at line %d',
                    $file->getPathname(),
                    $e->getMessage(),
                    $e->getLine()
                )
            );
        } catch (Exception $e) {
            $this->output->writeln(
                sprintf(
                    '<error>ERROR:</error> <info>%s</info> with <info>%s</info>',
                    $file->getPathname(),
                    $e->getMessage()
                )
            );
        }
    }

    /**
     * @param Crawler $crawler
     */
    protected function getMethodDefinitions($crawler)
    {
        $methodDefinitions = $crawler->filter('#method-info > div');

        $this->output->writeln(sprintf("Found %d definitions:", $methodDefinitions->count()));

        foreach ($methodDefinitions as $definition) {
            $operationData = $this->parseOperationData($definition);

            $this->output->writeln(
                sprintf(
                    "<comment>%s</comment> <info>%s</info>",
                    $operationData['httpMethod'],
                    $operationData['uri']
                )
            );
            $this->output->writeln(
                sprintf(
                    "<comment>Summary:</comment> <info>%s</info>",
                    $operationData['summary']
                )
            );
            $this->output->writeln(
                sprintf(
                    "<comment>Parameters:</comment> <info>%s</info>",
                    implode(",", array_keys($operationData['parameters']))
                )
            );

            $operation = $this->dialog->ask(
                $this->output,
                "<question>How do you wish to name this Operation? [".$operationData['operation']."]</question>",
                $operationData['operation']
            );

            unset($operationData['operation']);

            $apiType = $this->dialog->ask(
                $this->output,
                "<question>Which API? [v2]</question>",
                'v2',
                array_keys($this->apis)
            );

            $this->apis[$apiType][$operation] = $operationData;
        }

    }

    /**
     * @param DOMElement $definition
     * @return array
     */
    protected function parseOperationData($definition)
    {
        $crawler = new Crawler($definition);

        $operationFilter = $crawler->filter('h2');
        $operation       = str_replace(' ', '', $operationFilter->first()->text());

        $uriData = $crawler->filter('.uri div');

        preg_match('|[^/]*([^\n]*)\n|', $uriData->text(), $matches);
        $uri = $matches[1];

        $uriParams = array();
        if (strpos($uri, ":") !== false) {
            preg_match_all("|(:[^/]*)|", $uri, $uriParams);
            $uriParams = array_shift($uriParams);
        }

        $method = $uriData->filter('.muted')->text();

        $summaryNode = $crawler->filter('.leading-top p');
        $summary = ($summaryNode->count() > 0)? $summaryNode->text():null;

        $parameterList = $crawler->filter('dl.rounded-all dt span');
        $params = array();
        foreach ($parameterList as $parameter) {
            /** @var $parameter DOMElement */

            $params[$parameter->textContent] = array(
                'required' => ($parameter->getAttribute('class') == 'param_required'),
                'location' => ($method == 'GET') ? 'query' : 'postField',
            );
        }

        if (isset($uriParams) && count($uriParams) > 0) {
            foreach ($uriParams as $param) {
                $params[str_replace(':', '', $param)] = array(
                    'required' => true,
                    'location' => 'uri'
                );
            }
        }

        //Update Operation
        if ($method == 'GET') {
            $operation = ucfirst(strtolower($method) . $operation);
        }

        return array(
            'operation'  => $operation,
            'httpMethod' => $method,
            'uri'        => $uri,
            'summary'    => $summary,
            'parameters' => $params
        );

    }
}
