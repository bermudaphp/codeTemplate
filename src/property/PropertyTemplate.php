<?php

namespace Bermuda\CodeTemplate\Property;

use Bermuda\Stdlib\StrWrp;
use Bermuda\CodeTemplate\DefaultValueTemplate;
use Bermuda\CodeTemplate\TemplateInterface;
use Bermuda\CodeTemplate\types\Types;
use Bermuda\CodeTemplate\Visibility;

class PropertyTemplate implements TemplateInterface
{
    public readonly Types $types;
    public readonly ?DefaultValueTemplate $defaultValue;

    public function __construct(
        public readonly string $name,
        public readonly Visibility $visibility = Visibility::private,
        ?array  $types = null,
        public readonly bool $isReadonly = false,
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
        $end = ';';
        $str = $this->visibility->name . ' ';

        if ($this->isReadonly) {
            $str .= 'readonly  ';
        }

        $str .= $this->types->render();
        $str = rtrim($str, ' ');
        $str .= " \$$this->name";

        if ($this->defaultValue !== null) {
            $str .= $this->defaultValue->render();
        }

        return $str . $end;
    }

    public static function parse(string $string): self
    {

        $prop = new StrWrp($string);
        $allowsNull = false;

        if ($prop->startsWith('_')) {
            $visibility = Visibility::private;
            $prop = $prop->ltrim('_');
        } elseif ($prop->startsWith('#')) {
            $visibility = Visibility::protected;
            $prop = $prop->ltrim('#');
        } else {
            $visibility = Visibility::public;
        }

        if ($prop->contains(':')) {
            list($name, $types) = $prop->explode(':', 2);
            $typesNormalized = [];
            foreach ($types->explode('|') as $type) {
                $type = self::normalizeType($type, $allowsNull);
                if ($type) $typesNormalized[] = $type;
            }
        }

        return new static(
            $name ?? throw new \RuntimeException('Invalid string format'),
            $visibility,
                isset($typesNormalized) ? new Types($typesNormalized, $allowsNull) : null,
            allowsNull: $allowsNull
        );
    }

    private static function normalizeType(StrWrp $type, &$allowsNull):? string
    {
        if ($type->startsWith('?')) {
            $allowsNull = true;
            $type = $type->ltrim('?');
        }

        if (
            $type->equals([
                'int', 'bool', 'null',
                'string', 'object', 'array'
            ])
        ) {
            return $type->toString();
        } elseif ($type->equals('datetime')) {
            return '\DateTimeInterface';
        } elseif ($type->equals('carbon')) {
            return '\Carbon\CarbonInterface';
        } else {
            return class_exists($type->toString()) ? $type->toString() : null;
        }
    }
}
