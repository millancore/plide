<?php

namespace Phlide\Command;

use Phlide\Config;
use Phlide\Phlide;
use Phlide\Support\Directory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'export',
    description: 'Export a presentation'
)]
class ExportCommand extends Command
{
    private Config $config;

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
    }

    public function execute(InputInterface $input, OutputInterface $output) : int
    {
        $name = $input->getArgument('name');

        $presentationPath = new Directory(
            $this->config->joinPath($this->config->getPresentationPath(), $name)
        );

        if (!$presentationPath->has('index.php')) {
            $output->writeln(sprintf('<error>%s</error>', 'Presentation does have an index.php file'));
            return Command::FAILURE;
        }

        ob_start();
        require $presentationPath->getPath() . DIRECTORY_SEPARATOR . 'index.php';
        $content = ob_get_clean();

        $exportPath = Directory::create(
            $this->config->joinPath($this->config->getExportPath(), $name)
        );

        file_put_contents($exportPath->getPath() . DIRECTORY_SEPARATOR . 'index.html', $content);


        $presentationPath->copyTo($exportPath, function ($file) {
            return $file !== 'index.php';
        });

        $output->writeln(sprintf('<info>%s</info>', 'Presentation exported'));

        return Command::SUCCESS;
    }


}