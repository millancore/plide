<?php

namespace Plide\View;

class BladeCompiler extends \Illuminate\View\Compilers\BladeCompiler
{
    protected function compileComponentTags($value): string
    {
        if (! $this->compilesComponentTags) {
            return $value;
        }

        return (new ComponentTagCompiler(
            $this->classComponentAliases, $this->classComponentNamespaces, $this
        ))->compile($value);
    }

}