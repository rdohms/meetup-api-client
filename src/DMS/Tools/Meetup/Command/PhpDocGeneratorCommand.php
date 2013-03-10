<?php

namespace DMS\Tools\Meetup\Command;

use Guzzle\Service\Description\Operation;
use Guzzle\Service\Description\ServiceDescription;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\DialogHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PhpDocGeneratorCommand extends Command
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


    protected function configure()
    {
        $this
            ->setName('dms:meetup:generate-phpdoc')
            ->setDescription('Generates phpDoc code to document available methods in the client using @method syntax.')
            ->setDefinition(
                array(
                    new InputArgument('file', InputArgument::REQUIRED, 'JSON file with service definitions.'),
                )
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input  = $input;
        $this->output = $output;
        $this->dialog = $this->getHelperSet()->get('dialog');

        $definitionFile = $this->input->getArgument('file');
        $serviceDescriptions = ServiceDescription::factory($definitionFile);

        $operations = $serviceDescriptions->getOperations();

        foreach ($operations as $operation) {

            /** @var $operation Operation */
            $output->writeln(sprintf(
                    '* @method \Guzzle\Http\Message\Response %s(array $args = array())',
                    lcfirst($operation->getName())
                ));
        }

    }

}
