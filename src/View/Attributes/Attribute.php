<?php

namespace Plide\View\Attributes;

class Attribute
{
    public function __construct(
        private readonly string $alias,
        private readonly string $key,
        private string          $value = ''
    )
    {
        //
    }

    public function getAlias() : string
    {
        return $this->alias;
    }

    public function getKey() : string
    {
        return $this->key;
    }

    public function getValue() : string
    {
        return $this->value;
    }

    public function setValue(string $newValue) : void
    {
        $this->value = $newValue;
    }

    public function __toString() : string
    {
        if (empty($this->value)) {
            return sprintf('%s', $this->key);
        }

        return sprintf('%s="%s"', $this->key, $this->value);
    }

    public function is(string $key) : bool
    {
        return $this->alias === $key;
    }
}