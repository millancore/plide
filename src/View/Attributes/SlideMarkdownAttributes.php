<?php

namespace Plide\View\Attributes;

use Plide\Contract\Attributes;

class SlideMarkdownAttributes implements Attributes
{
    private array $attributes;

    public function __construct()
    {
        $attributes = [
            'file' => 'data-markdown',
            'separator' => 'data-separator',
            'separator-vertical' => 'data-separator-vertical',
            'separator-notes' => 'data-separator-notes',
            'charset' => 'data-charset',
        ];

        foreach ($attributes as $alias => $key) {
            $this->attributes[] = new Attribute($alias, $key);
        }

    }

    public function get(): array
    {
        return $this->attributes;
    }
}