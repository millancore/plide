<?php

use Plide\Command\CreateCommand;
use Plide\Config;
use Plide\Contract\Application;
use Plide\Plide;
use Symfony\Component\Console\Tester\CommandTester;

$config = new Config();

// Create test presentation
$create = new CommandTester(new CreateCommand($config));
$create->execute(['name' => 'test']);

$plide = new Plide($config->getPresentationPath().'/test');

it('it should binding self instance', function () use ($plide) {

   expect($plide->get('Plide'))->toBe($plide)
       ->and($plide->get(Application::class))->toBe($plide);
});


it('it should binding view instances', function () use ($plide) {

    expect($plide->get('files'))->toBeInstanceOf(\Illuminate\Filesystem\Filesystem::class)
        ->and($plide->get('config'))->toBeInstanceOf(\Illuminate\Config\Repository::class)
        ->and($plide->get('events'))->toBeInstanceOf(\Illuminate\Events\Dispatcher::class)
        ->and($plide->get('view'))->toBeInstanceOf(\Illuminate\Contracts\View\Factory::class);
});


afterAll(function () use ($config) {
    (new \Plide\Support\Directory(
        $config->getPresentationPath().'/test'
    ))->remove();
});


