<?php

use Plide\Command\CreateCommand;
use Plide\Support\Directory;
use Plide\Config;
use Symfony\Component\Console\Tester\CommandTester;
use Plide\Command\ShowCommand;

it('can start php server to show presentation', function () {

    $config = new Config();

    $presentation = new CommandTester(new CreateCommand($config));
    $command = new CommandTester(new ShowCommand($config));

    // Create
    $presentation->execute([
        'name' => 'test'
    ]);

    // Show
    $command->execute([
        'name' => 'test',
        '--port' => 8081,
        '--test' => true
    ]);

    $command->assertCommandIsSuccessful();
    expect($command->getDisplay())
        ->toBe(sprintf(
            'php -S localhost:8081 -t %s',
            $config->joinPath($config->getPresentationPath(), 'test').PHP_EOL
        ));

    (new Directory($config->getPresentationPath().'/test'))->remove();

});
