<?php

namespace Bermuda\CodeTemplate\Module;

use Bermuda\CodeTemplate\Template;

class EntityTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php
%namespace%

use Ramsey\Uuid\UuidFactoryInterface;

class %EntityClass%
{
    public static function fromData(%EntityClass%Data $data, ?UuidFactoryInterface $factory = null): static
    {
        return new static(
          
        );
    }
}
EOD;
    }
}