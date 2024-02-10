<?php

namespace Plide\Command;

use Plide\Config;
use Plide\Support\Directory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;


#[AsCommand(
    name: 'show',
    description: 'Show a presentation'
)]
class ShowCommand extends Command
{
    private  Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;

        parent::__construct();
    }

    protected function configure() : void
    {
        $this->addArgument(
            'name',
            InputArgument::REQUIRED,
            'The name of the presentation folder'
        );

        $this->addOption(
            'port',
            'p',
            InputArgument::OPTIONAL,
            'The port to run the server on',
            8081
        );
    }

    public function execute(InputInterface $input, OutputInterface $output) : int
    {
        $name = $input->getArgument('name');
        $port = $input->getOption('port');

        $plidePresentationPath = $this->config->getPresentationPath();

        if(str_starts_with($name, basename($plidePresentationPath))) {
            $name = str_replace(basename($plidePresentationPath), '', $name);
        }

        $presentationPath = $this->config->joinPath($plidePresentationPath, $name);

        if(!is_dir($presentationPath)) {
            $output->writeln(
                sprintf('<error>%s</error>', 'Presentation does not exist')
            );
            return Command::FAILURE;
        }

        $presentation = new Directory($presentationPath);

        if(!$presentation->has('dist')) {
            $output->writeln("Compile assets for the first time");
            shell_exec("npm run build");
        }

        shell_exec(sprintf("php -S localhost:%d -t %s", $port, $presentation->getPath()));

        return Command::SUCCESS;
    }

}