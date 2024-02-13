<?php

namespace Plide\Enum;

use Plide\Contract\Attributes;
use Plide\View\Attributes\SlideAttributes;
use Plide\View\Attributes\SlideMarkdownAttributes;

enum Slide
{
    case Slide;
    case Markdown;

    public function getAttributes() : Attributes
    {
       return match($this) {
            self::Slide => new SlideAttributes,
            self::Markdown => new SlideMarkdownAttributes,
        };
    }

}
