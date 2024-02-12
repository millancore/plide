<?php

namespace Plide\Contract;

use Illuminate\Contracts\View\View;

interface Renderable
{
   public function render() : View;

}