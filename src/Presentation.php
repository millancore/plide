<?php

namespace Plide;

use Illuminate\Contracts\View\View;

abstract class Presentation
{
    abstract public function render() : View;
}