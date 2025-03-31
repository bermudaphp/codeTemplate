<?php

namespace Bermuda\CodeTemplate;

use Bermuda\CodeTemplate\Property\PropertyTemplate;
use Bermuda\CodeTemplate\Types\Types;

class ClassMethodTemplate implements TemplateInterface
{
    protected array $arguments = [];
    protected ?Types $returnTypes;

    /**
     * @param iterable<TemplateInterface>|null $arguments
     */
    public function __construct(
        public readonly string $name,
        ?iterable $arguments = null,
        public readonly Visibility $visibility = Visibility::public,
        ?array $returnTypes = null,
        bool $typesAllowsNull = false
    ) {
        foreach ($arguments as $argument) $this->addArgument($argument);
        $this->returnTypes = $returnTypes !== null ? new Types($returnTypes, $typesAllowsNull)
            : null;
    }

    public function addArgument(TemplateInterface $argument): void
    {
        $this->arguments[] = $argument;
    }

    public function render(): string
    {
        $str = Visibility::public->name . ' function ';
        $str .= $this->name;
        $str .= '(';

        foreach ($this->arguments as $argument) {
            $str .= $argument->render();
            if ($argument instanceof PropertyTemplate) {
                $str = rtrim($str, ';');
            }
            $str .= ', ';
        }

        $str = rtrim($str, ', ');
        $str .= ')';

        if ($this->returnTypes !== null) {
            $str .= ": " . $this->returnTypes->render();
        }

        $str .= PHP_EOL;
        $str .= '{';
        $str .= PHP_EOL;
        $str .= '}';

        return $str;
    }
}
