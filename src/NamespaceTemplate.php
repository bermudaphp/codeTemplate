<?php

namespace Bermuda\CodeTemplate;

class NamespaceTemplate implements TemplateInterface
{
    public function __construct(
        private readonly array $segments
    ) {
    }

    public function render(): string
    {
        return count($this->segments) > 0 ? 'namespace ' . implode('\\', $this->segments) . ';' : '';
    }
}