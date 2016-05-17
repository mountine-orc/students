<?php

namespace StudentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class StudentGeneratePathCommand
 * @package StudentBundle\Command
 */
class StudentGeneratePathCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('student:generate:path')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        $pathCreator = $this->getContainer()->get("path_creator");
        $pathCreator->updatePath();

        $output->writeln('Command result:');
        $output->writeln('Command time: ' . round(microtime(true) - $startTime, 3) . " s.");
        $output->writeln('Memory: ' . round(memory_get_usage(true) / 1000000, 3) . " Mb.");
    }

}
