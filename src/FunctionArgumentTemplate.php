<?php

namespace Bermuda\CodeTemplate;

use Bermuda\CodeTemplate\Types\Types;

class FunctionArgumentTemplate implements TemplateInterface
{
    public readonly Types $types;
    public readonly ?DefaultValueTemplate $defaultValue;

    public function __construct(
        public readonly string $name,
        ?array  $types = null,
        public readonly bool  $allowsNull = false,
        null|DefaultValueTemplate|string $defaultValue = null,
    ) {
        $this->types = $types !== null ? new Types($types, $this->allowsNull)
            : new Types(['mixed'], $this->allowsNull);

        if (is_string($defaultValue)) {
            $defaultValue = new DefaultValueTemplate($defaultValue);
        } elseif ($defaultValue === null && $this->allowsNull ) {
            $defaultValue = new DefaultValueTemplate('null');
        }

        $this->defaultValue = $defaultValue;
    }

    public function render(): string
    {

        $str = $this->types->render();
        $str = rtrim($str, ' ');
        $str .= " \$$this->name";

        if ($this->defaultValue !== null) {
            $str .= $this->defaultValue->render();
        }

        return $str;
    }

    /**
     * @return DefaultValueTemplate|null
     */
    public function getDefaultValue(): ?DefaultValueTemplate
    {
        return $this->defaultValue;
    }
}
