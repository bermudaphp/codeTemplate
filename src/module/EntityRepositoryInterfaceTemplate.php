<?php

namespace Bermuda\CodeTemplate\Module;

use Bermuda\CodeTemplate\Template;

class EntityRepositoryInterfaceTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php
%namespace%

interface %EntityClass%RepositoryInterface
{
    public function save(%EntityClass% $entity): void ;
}
EOD;
    }
}