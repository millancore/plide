<?php

use Plide\Command\CreateCommand;
use Plide\Config;
use Symfony\Component\Console\Tester\CommandTester;
use Plide\Support\Directory;

it('it can create a presentation', function () {
    $config = new Config();

    $command = new CommandTester(new CreateCommand($config));

    $command->execute([
        'name' => 'test'
    ]);

    $command->assertCommandIsSuccessful();
    expect($command->getDisplay())
        ->toBe('Created "test" presentation'.PHP_EOL);

    $test = new Directory(
        $config->joinPath($config->getPresentationPath(), 'test')
    );

    expect(iterator_count($test->scanRecursive()))
        ->toBe(5);

    $test->remove();
});
