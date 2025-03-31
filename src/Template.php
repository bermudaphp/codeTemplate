<?php

namespace Bermuda\CodeTemplate;

abstract class Template implements TemplateInterface
{
    protected array $tokens = [];
    public function setTokens(array $tokens): void
    {
        foreach ($tokens as $name => $token) $this->setToken($name, $token);
    }

    public function setToken(string $name, TemplateInterface|string $token): void
    {
        $wrp = $this->getTokenWrapper();

        if (!str_starts_with($name, $wrp) || !str_ends_with($name, $wrp)) {
            $name = "$wrp$name$wrp";
        }

        $this->tokens[$name] = $token;
    }

    protected function getTokenWrapper(): string
    {
        return '%';
    }

    public function render(): string
    {
        foreach ($this->getRequiredTokens() as $token) {
            if (!isset($this->tokens[$token])) throw new RenderException('Missing required token: ' . $token);
        }

        $replace = array_map(static fn(string|TemplateInterface $token) => is_string($token) ? $token : $token->render(),
            array_values($this->tokens)
        );

        return str_replace(array_keys($this->tokens), $replace, $this->getBaseTemplate());
    }

    protected function getRequiredTokens(): array
    {
        return [];
    }

    abstract protected function getBaseTemplate(): string ;
}