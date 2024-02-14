<?php

namespace Plide\Command;

use Plide\Config;
use Plide\Plide;
use Plide\Support\Directory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use ZipArchive;

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

        $presentation = new Directory(
            $this->config->joinPath($this->config->getPresentationPath(), $name)
        );

        if (!$presentation->has('index.php')) {
            $output->writeln(sprintf('<error>%s</error>', 'Presentation does have an index.php file'));
            return Command::FAILURE;
        }

        $exportPath = $this->config->joinPath($this->config->getExportPath(), $name);

        $this->createZip($presentation, $exportPath);

        if (!file_exists($exportPath . '.zip')) {
            $output->writeln(sprintf('<error>%s</error>', 'Export failed'));
            return Command::FAILURE;
        }

        $output->writeln(sprintf('<info>%s</info>', 'Presentation exported'));

        return Command::SUCCESS;
    }

    /** TODO: Move to dedicate class */
    private function createZip(Directory $presentation, string $exportPath) : void
    {
        $zip = new ZipArchive;
        $zip->open($exportPath . '.zip', ZipArchive::CREATE);

        $this->addRenderedIndexToZip($zip, $presentation);

        $files = $presentation->scanRecursive();

        foreach ($files as $file) {
            if ($file->isFile()) {

                if ($file->getExtension() === 'php') {
                    continue;
                }

                $relativeFilePath = str_replace(
                    $presentation->getPath() . DIRECTORY_SEPARATOR, '',
                    $file->getPathname()
                );

                $zip->addFile($file->getPathname(), $relativeFilePath);
            }
        }

        $zip->close();
    }

    private function addRenderedIndexToZip(ZipArchive $zip, Directory $directory) : void
    {
        ob_start();
        require $directory->getPath() . DIRECTORY_SEPARATOR . 'index.php';

        $content = ob_get_clean();
        $zip->addFromString('index.html', $content);
    }


}