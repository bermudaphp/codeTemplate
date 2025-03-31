<?php

namespace Bermuda\CodeTemplate;

interface TemplateInterface
{
    /**
     * @throws RenderException
     */
    public function render(): string ;
}
