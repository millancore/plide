<?php

use Illuminate\Container\Container;

if (! function_exists('view')) {
    function view($view = null, $data = [], $mergeData = [])
    {
        $plide = Container::getInstance();
        $factory = $plide->make('view');

        if (func_num_args() === 0) {
            return $factory;
        }

        $view = sprintf('%s.%s', basename($plide->getBasepath()), $view);

        return $factory->make($view, $data, $mergeData);
    }
}
