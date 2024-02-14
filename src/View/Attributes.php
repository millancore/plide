<?php

namespace Plide\View;

use Plide\Enum\Slide;
use Plide\View\Attributes\Attribute;

class Attributes
{
    public static function resolve(Slide $slideType, array $definedVars) : string
    {
        $attributes = $slideType->getAttributes()->get();

       $result = '';
        /** @var Attribute $attribute */
        foreach ($attributes as $attribute) {
            if (array_key_exists($attribute->getAlias(), $definedVars)) {

                $value = $definedVars[$attribute->getAlias()];

                if ($attribute->is('bg-color')) {
                    $value = TailwindColors::create()->bgTransform($value);
                }

                $attribute->setValue($value);

                $result .=  $attribute . ' ';
            }
        }

        return rtrim($result);
    }

}