<?php

namespace Bermuda\CodeTemplate\Types;

use Bermuda\CodeTemplate\TemplateInterface;

class Types implements TemplateInterface, \Countable
{
    public const string never = 'never';
    public const string void = 'void';
    public const string null = 'null';
    public const string false = 'false';
    public const string true = 'true';
    public const string bool = 'bool';
    public const string array = 'array';
    public const string string = 'string';
    public const string int = 'int';
    public const string float = 'float';
    public const string object = 'object';
    public const string callable = 'callable';

    public readonly array $types;

    public function __construct(array $types, public readonly bool $allowsNull = false)
    {
        $this->types = array_values($types);
    }

    public function count(): int
    {
        return count($this->types);
    }

    public function render(): string
    {
        $types = $this->types;

        if ($this->allowsNull && count($types) === 1) {
            return '?' . $types[0]?->render() ?? $types[0];
        } elseif ($this->allowsNull && (!in_array('mixed', $this->types) && !in_array('null', $types))) {
            array_unshift($types, 'null');
        }

        return implode('|', array_map(static function (string|TemplateInterface $type): string {
            $str = is_string($type) ? $type : $type->render();
            if ($type instanceof IntersectionTypes) $str = "($str)";

            return $str;
        }, $types));
    }
}
