<?php

namespace Bermuda\CodeTemplate;

class ClassTemplate extends Template
{
    protected function getBaseTemplate(): string
    {
        return <<<'EOD'
<?php 
%NAMESPACE%;

%import%

class %ClassName% %extends% %implements%
{
%use%

%properties%

%methods%
}
EOD;
    }
}