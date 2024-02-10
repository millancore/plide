<?php

use Illuminate\Container\Container;
use Plide\Plide;

if (! function_exists('view')) {
    function view($view = null, $data = [], $mergeData = []) : Illuminate\Contracts\View\View
    {
        /** @var Plide $plide */
        $plide = Container::getInstance();

        $factory = $plide->make('view');
        if (func_num_args() === 0) {
            return $factory;
        }

        $view = sprintf('%s/%s', $plide->getPresentationName(), $view);

        return $factory->make($view, $data, $mergeData);
    }
}

if (!function_exists('asset')) {
    function asset($path): string
    {
        /** @var Plide $plide */
        $plide = Container::getInstance();

        return $plide->getAssetPath().$path;
    }
}
