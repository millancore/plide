<?php

namespace Phlide;

abstract class Presentation
{
    abstract public function render() : string;
}