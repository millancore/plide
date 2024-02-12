<?php

use Illuminate\Container\Container;
use Illuminate\Contracts\View\View;
use Plide\Plide;

if (!function_exists('view')) {
    function view($view = null, $data = [], $mergeData = []): View
    {
        /** @var Plide $plide */
        $plide = Container::getInstance();

        $factory = $plide->make('view');
        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make(
            $plide->getPresentationName() . DIRECTORY_SEPARATOR . $view,
            $data,
            $mergeData
        );
    }
}

if (!function_exists('asset')) {
    function asset($path): string
    {
        /** @var Plide $plide */
        $plide = Container::getInstance();

        return $plide->getAssetPath() . DIRECTORY_SEPARATOR . $path;
    }
}
