<?php

declare(strict_types=1);

namespace Wcomnisky\Flagship\Context;

class Context implements ContextInterface
{
    private $contextList = [];

    /**
     * {@inheritDoc}
     */
    public function add(string $key, string $value): void
    {
        $this->contextList[$key] = $value;
    }

    /**
     * {@inheritDoc}
     */
    public function set(array $context): void
    {
        $this->contextList = $context;
    }

    /**
     * {@inheritDoc}
     */
    public function getList(): array
    {
        return $this->contextList;
    }
}
