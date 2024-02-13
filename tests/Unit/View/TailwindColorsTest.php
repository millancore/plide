<?php

use Plide\View\TailwindColors;

it('it can convert bg color class to hex color', function () {

    $tailwindColors = new TailwindColors;

    expect($tailwindColors->bgTransform('bg-red-500'))
        ->toBe('#ef4444')
        ->and($tailwindColors->bgTransform('bg-zinc-200'))
        ->toBe('#e4e4e7')
        ->and($tailwindColors->bgTransform('bg-green-500'))
        ->toBe('#22c55e')
        ->and($tailwindColors->bgTransform('bg-blue-500'))
        ->toBe('#3b82f6')
        ->and($tailwindColors->bgTransform('bg-pink-700'))
        ->toBe('#be185d');
});
