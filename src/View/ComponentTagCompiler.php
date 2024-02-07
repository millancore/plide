<?php

namespace Phlide\View;

class ComponentTagCompiler extends \Illuminate\View\Compilers\ComponentTagCompiler
{
    public function guessClassName(string $component): string
    {
        return 'Phlide\\Components\\'.$this->formatClassName($component);
    }

}