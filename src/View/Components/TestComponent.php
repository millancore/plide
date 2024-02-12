<?php

namespace Plide\View\Components;

use Illuminate\Console\View\Components\Component;

class TestComponent extends Component
{
    public function render()
    {
        return <<<'blade'
<div>Test Component </div>
blade;

    }
}