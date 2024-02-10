<?php

use Plide\Support\Directory;

it('can scan directory', function () {

    $stubsDir = new Directory(ROOT_PATH . '/src/Stub');
    $stubs = $stubsDir->scanRecursive();

    expect($stubs)->toBeInstanceOf(RecursiveIteratorIterator::class)
        ->and(iterator_count($stubs))
        ->toBeGreaterThan(0);
});


it('error try to open not root directory', function () {
    new Directory('/tmp');
})->throws(
    InvalidArgumentException::class,
    'Directory /tmp failed isRootDir validation'
);

it('is writable', function () {

    $stubsDir = new Directory(ROOT_PATH . '/presentations');
    expect($stubsDir->isWritable())->toBeTrue();
});

it('can copy directory', function () {

    $presentationDir = Directory::create(
        ROOT_PATH . '/presentations/test'
    );

    (new Directory(ROOT_PATH . '/src/Stub'))
        ->copyTo($presentationDir);

    expect(iterator_count($presentationDir->scanRecursive()))
        ->toBeGreaterThan(0);

    $presentationDir->remove();
});

it('can copy and modify the file extension', function () {

    $presentationDir = Directory::create(
        ROOT_PATH . '/presentations/test'
    );

    (new Directory(ROOT_PATH . '/src/Stub'))
        ->copyTo($presentationDir, function ($file) {
            return str_replace('.stub', '', $file);
        });

    expect(iterator_count($presentationDir->scanRecursive()))
        ->toBeGreaterThan(0)
        ->and($presentationDir->has('index.php'))
        ->toBeTrue();

    $presentationDir->remove();
});
