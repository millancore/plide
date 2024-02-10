<?php

use Plide\Config;

it('should return the root path', function () {
    $config = new Config;
    expect($config->getRootPath())->toBe(ROOT_PATH);
});

it('should return the presentation path', function () {
    $config = new Config;
    expect($config->getPresentationPath())->toBe(ROOT_PATH . '/presentations');
});

it('should return the stub path', function () {
    $config = new Config;
    expect($config->getStubPath())->toBe(ROOT_PATH . '/src/Stub');
});

it('should return the view paths', function () {
    $config = new Config;
    expect($config->getViewPaths())->toBe([
        'view' => [
            'paths' => [
                ROOT_PATH . '/presentations',
                ROOT_PATH . '/resources/views'
            ],
            'compiled' => ROOT_PATH . '/cache'
        ]
    ]);
});

it('should join paths', function () {
    $config = new Config;

    expect($config->joinPath('foo', 'bar'))->toBe('foo/bar');
});
