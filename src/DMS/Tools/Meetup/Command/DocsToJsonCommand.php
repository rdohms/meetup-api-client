<?php

namespace DMS\Tools\Meetup\Command;

use DMS\Tools\ArrayHelper;
use DMS\Tools\Meetup\Api;
use DMS\Tools\Meetup\Operation;
use DOMElement;
use Exception;
use Guzzle\Http\Client;
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

class DocsToJsonCommand extends Command
{
    const API_DOCS = "http://api.meetup.com/docs";

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
            ->setName('dms:meetup:import-to-docs')
            ->setDescription(
                'Parses online json documentation into Guzzle Service definitions'
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
            3 => Api::build('Meetup', 3, 'Meetup API v3 methods'),
            2 => Api::build('Meetup', 2, 'Meetup API v2 methods'),
            1 => Api::build('Meetup', 1, 'Meetup API v1 methods'),
        );

        $this->output->writeln('Downloading data from API docs ...');
        $data = $this->getApiData();

        $this->output->writeln('Parsing data from API docs ...');
        foreach ($data['docs'] as $definition) {
            $operation = Operation::createFromApiJsonDocs($definition);
            $this->apis[ArrayHelper::read($definition, 'api_version', '1')]->addOperation($operation);
        }

        $this->output->writeln('Dumping data from API docs ...');
        foreach ($this->apis as $api) {
            $filename = sys_get_temp_dir() . '/' . sprintf('meetup_v%d_services.json', $api->apiVersion);

            $this->output->writeln(sprintf('Writing to %s ...', $filename));
            file_put_contents($filename, $api->toJson());
            $this->output->writeln(sprintf('Done with %s.', $filename));
        }

    }

    public function getApiData()
    {
        $client = new Client(self::API_DOCS);
        $response = $client->get()->send();

        return $response->json();
    }
}
