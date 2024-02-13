<?php

use Plide\Command\CreateCommand;
use Plide\Config;
use Symfony\Component\Console\Tester\CommandTester;
use Plide\Support\Directory;

$config = new Config();

it('can create a presentation', function () use ($config) {

    $command = new CommandTester(new CreateCommand($config));

    $command->execute([
        'name' => 'test_2'
    ]);

    $command->assertCommandIsSuccessful();
    expect($command->getDisplay())
        ->toBe('Created "test_2" presentation'.PHP_EOL);

    $test = new Directory(
        $config->joinPath($config->getPresentationPath(), 'test_2')
    );

    expect(iterator_count($test->scanRecursive()))
        ->toBe(5);

    $test->remove();
});

it('can not create with especial characters', function () use ($config) {

    $command = new CommandTester(new CreateCommand($config));

    $command->execute([
        'name' => 'test_2!@#$%^&*()'
    ]);

    expect($command->getDisplay())
        ->toBe('Invalid name, please use only letters, numbers and underscores'.PHP_EOL);
});
