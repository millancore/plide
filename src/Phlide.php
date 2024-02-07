<?php

namespace Phlide;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Phlide\Contracts\ApplicationInterface;
use Phlide\View\ViewServiceProvider;

class Phlide extends Container implements ApplicationInterface
{
    private string $basePath;
    private array $terminatingCallbacks;
    protected $namespace;

    public function __construct(string $basePath)
    {
        $this->basePath = $basePath;
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
       $viewConfigPath = [
           'view' => [
               'paths' => [
                   PRESENTATION_PATH,
                   ROOT_PATH . '/resources/views'
               ],
               'compiled' => ROOT_PATH . '/cache',
           ]
       ];

       $this->bind('files', fn() => new Filesystem);
       $this->bind('config', fn() => new Repository($viewConfigPath));
       $this->bind('events', fn() => new Dispatcher($this));

       $viewService = new ViewServiceProvider($this);

       $this->alias('view', Factory::class);

       $viewService->register();
    }

    /**
     * Register a terminating callback with the application.
     *
     * @param  callable|string  $callback
     * @return $this
     */
    public function terminating($callback)
    {
        $this->terminatingCallbacks[] = $callback;

        return $this;
    }

    public function render(?Presentation $presentation = null): void
    {
        if ($presentation) {
          print $presentation->render();
        }

        print $this->make('view')
              ->make(sprintf('%s.show', basename($this->basePath)));
    }


}