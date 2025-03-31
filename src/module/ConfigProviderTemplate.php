<?php

namespace Bermuda\CodeTemplate\Module;

use Bermuda\CodeTemplate\Template;

class ConfigProviderTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php
%namespace%

class ConfigProvider extends \Bermuda\Config\ConfigProvider
{
    protected function getFactories(): array
    {
        return [
            %EntityClass%RepositoryInterface::class => [%EntityClass%Repository::class, 'createFromContainer']
        ];
    }

    protected function getAliases(): array
    {
        return [%EntityClass%FactoryInterface::class => %EntityClass%RepositoryInterface::class];
    }

    public function getProviders(): array
    {
        return [];
    }
}
EOD;
    }
}
