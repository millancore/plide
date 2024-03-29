<?php

namespace Plide\Command;

use InvalidArgumentException;
use Plide\Config;
use Plide\Support\Directory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(
    name: 'new',
    description: 'Create a new presentation'
)]
class CreateCommand extends Command
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'The name of the presentation folder'
        );

    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $name = $input->getArgument('name');

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
            $output->writeln(
                sprintf(
                    '<error>%s</error>',
                     'Invalid name, please use only letters, numbers and underscores')
            );
            return Command::FAILURE;
        }

        try {
            $presentationPath = Directory::create(
                $this->config->joinPath($this->config->getPresentationPath(), $name)
            );

        } catch (InvalidArgumentException $e) {
            $output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
            return Command::FAILURE;
        }

        $stubsDirectory = new Directory($this->config->getStubPath());

        $stubsDirectory->copyTo($presentationPath, function ($file) {
            return str_replace('.stub', '', $file);
        });


        $output->writeln(sprintf(
            '<info>Created "%s" presentation</info>',
            basename($presentationPath->getPath())
        ));

        return Command::SUCCESS;
    }

}