<?php

namespace Plide\View\Attributes;

use Plide\Contract\Attributes;

class SlideAttributes implements Attributes
{
   private array $attributes;

    public function __construct()
    {
        $attributes = [
            // Colors
            'bg-color' => 'data-background-color',
            'bg-gradient' => 'data-background-gradient',

            // Images
            'bg-image' => 'data-background-image',
            'bg-position' => 'data-background-position',
            'bg-repeat' => 'data-background-repeat',

            // Video
            'bg-video' => 'data-background-video',
            'bg-video-loop' => 'data-background-video-loop',
            'bg-video-muted' => 'data-background-video-muted',

            // Iframe
            'bg-iframe' => 'data-background-iframe',
            'bg-interactive' => 'data-background-interactive',

            // General
            'bg-size' => 'data-background-size',
            'bg-opacity' => 'data-background-opacity',
        ];

        foreach ($attributes as $alias => $key) {
            $this->attributes[] = new Attribute($alias, $key);
        }

    }

    public function get() : array
    {
        return $this->attributes;
    }

}