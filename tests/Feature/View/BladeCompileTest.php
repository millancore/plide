<?php

use Illuminate\View\Compilers\BladeCompiler;
use Plide\Plide;

$plide = new Plide(__DIR__);

it('it should be a instance of Illuminate Blade', function () use ($plide) {

    $compiler = $plide->get('blade.compiler');

    expect($compiler)->toBeInstanceOf(BladeCompiler::class);
});

it('it can compile a Plide component', function () use ($plide) {

    $compiler = $plide->get('blade.compiler');

    $component = $compiler->compileString('<x-test-component />');

    expect($component)->toContain('Plide\View\Components\TestComponent::resolve');
});

