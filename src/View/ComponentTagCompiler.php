<?php

namespace Plide\View;

class ComponentTagCompiler extends \Illuminate\View\Compilers\ComponentTagCompiler
{
    public function guessClassName(string $component): string
    {
        return 'Plide\\View\\Components\\'.$this->formatClassName($component);
    }

}