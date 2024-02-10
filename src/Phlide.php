<?php

namespace Phlide;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Phlide\Contract\ApplicationInterface;
use Phlide\View\ViewServiceProvider;

class Phlide extends Container implements ApplicationInterface
{
    private Config $config;

    public function __construct(
        private readonly string $basePath
    )
    {
        $this->config = new Config;

        $this->registerBaseBindings();
        $this->registerViewProvider();

    }

    public function getBasePath() : string
    {
        return $this->basePath;
    }


    private function registerBaseBindings() : void
    {
        static::setInstance($this);
        $this->instance('phlide', $this);
        $this->instance(ApplicationInterface::class, $this);
    }

    private function registerViewProvider() : void
    {
       $this->bind('files', fn() => new Filesystem);
       $this->bind('config', fn() => new Repository(
           $this->config->getViewPaths()
       ));

       $this->bind('events', fn() => new Dispatcher($this));

       $viewService = new ViewServiceProvider($this);
       $this->alias('view', Factory::class);

       $viewService->register();
    }


    public function terminating($callback)
    {
        return $this;
    }

    public function render(?Presentation $presentation = null) : string
    {
        if ($presentation) {
            return $presentation->render();
        }

        return $this->make('view')
              ->make(sprintf('%s.show', basename($this->basePath)));
    }


}