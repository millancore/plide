<?php

namespace Plide;

abstract class Presentation
{
    abstract public function render() : string;
}