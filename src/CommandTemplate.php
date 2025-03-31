<?php

namespace Bermuda\CodeTemplate;

class CommandTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php
%namespace%

use Bermuda\App\Console\SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class %CommandClassName% extends SymfonyCommand
{
    protected function configure(): void
    {
        $this->setName('');
        $this->setDescription('');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // todo write the body of the command
    }
}
EOD;
    }
}