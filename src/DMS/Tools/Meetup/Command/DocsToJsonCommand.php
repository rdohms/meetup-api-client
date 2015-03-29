<?php

namespace DMS\Tools\Meetup\Command;

use DMS\Tools\Meetup\ValueObject\Api;
use DMS\Tools\Meetup\ValueObject\Operation;
use Guzzle\Http\Client;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Helper\TableHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use MathiasGrimm\ArrayPath\ArrayPath as arr;

/**
 * Class DocsToJsonCommand
 */
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

    /**
     * Setup Command
     */
    protected function configure()
    {
        $this
            ->setName('dms:meetup:import-to-docs')
            ->setDescription(
                'Parses online json documentation into Guzzle Service definitions'
            )
            ->setDefinition(array(
                new InputOption('debug-names', 'd', InputOption::VALUE_NONE, 'Show name conversion info'),
                new InputArgument(
                    'target-dir',
                    InputArgument::OPTIONAL,
                    'Where to save generated files',
                    sys_get_temp_dir()
                ),
            ))
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;

        $this->dialog = $this->getHelperSet()->get('dialog');

        $this->parseDocuments();
        $this->generateDefinitionFiles();
    }

    /**
     * Parse API Docs
     */
    protected function parseDocuments()
    {
        $this->apis = array(
            3 => Api::build('Meetup', 3, 'Meetup API v3 methods'),
            2 => Api::build('Meetup', 2, 'Meetup API v2 methods'),
            1 => Api::build('Meetup', 1, 'Meetup API v1 methods'),
            'stream' => Api::build('Meetup', 'stream', 'Meetup API Stream methods'),
        );

        $this->output->writeln('Downloading data from API docs ...');
        $data = $this->getApiData();

        /** @var TableHelper $nameConversionTable */
        $nameConversionTable = $this->getHelper('table');
        $nameConversionTable->setHeaders(array('v', 'Docs Name', 'Method', 'Path', 'Final Method Name'));

        $this->output->writeln('Parsing data from API docs ...');
        foreach ($data['docs'] as $definition) {

            $operation = Operation::createFromApiJsonDocs($definition);

            if ($operation === null) {
                continue;
            }

            $nameConversionTable->addRow(array(
                $operation->version,
                arr::get('name', $definition),
                arr::get('http_method', $definition),
                arr::get('path', $definition),
                $operation->name
            ));

            $this->apis[$operation->version]->addOperation($operation);
        }

        if ($this->input->getOption('debug-names')) {
            $nameConversionTable->render($this->output);
        }
    }

    /**
     * Read API json
     *
     * @return array|bool|float|int|string
     */
    public function getApiData()
    {
        $client = new Client(self::API_DOCS);
        $response = $client->get()->send();

        return $response->json();
    }

    protected function generateDefinitionFiles()
    {
        $path = $this->input->getArgument('target-dir');

        $this->output->writeln('Dumping data from API docs ...');
        foreach ($this->apis as $api) {
            $filename = $path . '/' . sprintf('meetup_v%s_services.json', $api->apiVersion);

            $this->output->writeln(sprintf('Writing to %s ...', $filename));
            file_put_contents($filename, $api->toJson());
            $this->output->writeln(sprintf('Done with %s.', $filename));
        }
    }
}
