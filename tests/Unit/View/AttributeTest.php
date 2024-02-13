<?php

use Plide\View\Attributes\Attribute;

it('can cast to string', function () {
    $attribute = new Attribute(
        'bg-color',
        'data-background-color',
        'bg-teal-500');

    expect((string) $attribute)->toBe('data-background-color="bg-teal-500"');
});

it('can render attribute without value', function () {
    $attribute = new Attribute(
        'separator',
        'data-separator');

    expect((string) $attribute)->toBe('data-separator');
});


it('can set value after construction', function () {
    $attribute = new Attribute(
        'separator',
        'data-separator');

    $attribute->setValue('---');

    expect((string) $attribute)->toBe('data-separator="---"');
});
