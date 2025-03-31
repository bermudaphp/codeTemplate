<?php

namespace Bermuda\CodeTemplate\Types;

class IntersectionTypes extends Types
{
    public function __construct(array $types, bool $allowsNull = false)
    {
        if (2 > count($types)) throw new \InvalidArgumentException('Argument $types must have at least two elements');
        parent::__construct($types, $allowsNull);
    }

    public function render(): string
    {
        $types = $this->types;

        if ($this->allowsNull) {
            return '(' . implode('&', $types) . ')|null';
        }

        return implode('&', $types);
    }
}
