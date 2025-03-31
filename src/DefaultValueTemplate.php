<?php

namespace Bermuda\CodeTemplate;

class DefaultValueTemplate implements TemplateInterface
{
    public function __construct(public readonly string $value)
    {
    }

    public function render(): string
    {
        return ' = ' . $this->value;
    }
}