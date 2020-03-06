<?php

declare(strict_types=1);

namespace Wcomnisky\Flagship\Context;

interface ContextInterface
{
    /**
     * Adds a new key-value pair to the context list
     *
     * @param string $key Key name. Must be unique otherwise overrides the existent.
     * @param string $value Value to be assigned to the key.
     */
    public function add(string $key, string $value): void;

    /**
     * Overrides the existing list of key-value pairs with the provided parameter
     *
     * @param array $context List of key-value pair to override the existing list.
     */
    public function set(array $context): void;

    /**
     * Returns the list of key-value pairs
     *
     * @return array List of key-value pairs
     */
    public function getList(): array;
}
