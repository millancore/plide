<?php

namespace Plide;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Plide\Contract\Application;
use Plide\Contract\Renderable;
use Plide\View\ViewServiceProvider;

class Plide extends Container implements Application
{
    private Config $config;
    private string $presentationName;

    public function __construct(
        private readonly string $basePath
    )
    {
        $this->config = new Config;
        $this->presentationName = basename($this->basePath);

        $this->registerBaseBindings();
        $this->registerViewProvider();
    }

    public function getPresentationName(): string
    {
        return $this->presentationName;
    }

    private function registerBaseBindings(): void
    {
        static::setInstance($this);
        $this->instance('Plide', $this);
        $this->instance(Application::class, $this);
    }

    private function registerViewProvider(): void
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


    public function getAssetPath(): string
    {
        return $this->basePath . '/assets';
    }

    public function render(
        ?Renderable $presentation = null
    ): string
    {
        if ($presentation) {
            return $presentation->render();
        }

        return view('show', [
            'name' => ucfirst($this->presentationName)
        ]);
    }


    /**
     * Add for compatibility with Laravel (Illuminate )
     */
    public function terminating($callback)
    {
        return $this;
    }


}