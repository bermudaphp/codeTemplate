<?php

namespace Bermuda\CodeTemplate\Module;

use Bermuda\CodeTemplate\Template;

class EntityFactoryInterfaceTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php
%namespace%

interface %EntityClass%FactoryInterface
{
    public function make%EntityClass%(%EntityClass%Data $data): %EntityClass% ;
}
EOD;
    }
}