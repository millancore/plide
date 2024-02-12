<?php

use Plide\View\ComponentTagCompiler;

it('should be a instance of Illuminate view components', function (){
    $compiler = new ComponentTagCompiler();

    expect($compiler)->toBeInstanceOf(\Illuminate\View\Compilers\ComponentTagCompiler::class);
});

it('guest class name resolve by Plide namespaces', function (){
    $compiler = new ComponentTagCompiler();

    expect($compiler->guessClassName('test-component'))
        ->toBe('Plide\\View\\Components\\TestComponent');
});