<?php

namespace Bermuda\CodeTemplate\Module;

use Bermuda\CodeTemplate\Template;

class EntityDataTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php
%namespace%

use Bermuda\Stdlib\Arrayable;

class %EntityClass%Data implements Arrayable
{
    public function toArray(): array
    {
        return array_filter(get_object_vars($this),
            static fn(mixed $v) => $v !== null
        );
    }
}
EOD;
    }
}