<?php

namespace Bermuda\CodeTemplate\Property;

use Bermuda\Stdlib\Arrayable;
use Bermuda\CodeTemplate\TemplateInterface;

final class PropertyCollection implements TemplateInterface, Arrayable
{
    private array $properties = [];
    public function __construct(iterable $propertyTemplates, public bool $isConstructorProperty = false)
    {
        foreach ($propertyTemplates as $propertyTemplate) $this->addProperty($propertyTemplate);
    }

    public function addProperty(PropertyTemplate $propertyTemplate): void
    {
        $this->properties[] = $propertyTemplate;
    }

    public function render(): string
    {
        $str = '';
        $glue = '';

        foreach ($this->properties as $propertyTemplate) {
            $str .= $propertyTemplate->render();
            if ($this->isConstructorProperty){
                $str = rtrim($str, ';');
                $str .= $glue;
                $glue = ', ';
            }
        }

        return $str;
    }

    public function toArray(): array
    {
        return $this->properties;
    }
}
