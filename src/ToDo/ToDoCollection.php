<?php

declare(strict_types=1);

namespace App\ToDo;

use RuntimeException;

use function array_map;
use function array_values;
use function count;

class ToDoCollection
{
    /** @var ToDo[] */
    public array $entities;

    /** @param ToDo[] $entities */
    public function __construct(array $entities = [])
    {
        $this->entities = array_values(array_map(
            static fn (ToDo $e) => $e,
            $entities,
        ));
    }

    public function first(): ToDo
    {
        $entity = $this->firstOrNull();

        if ($entity === null) {
            throw new RuntimeException('No ToDo found');
        }

        return $entity;
    }

    public function firstOrNull(): ToDo|null
    {
        return $this->entities[0] ?? null;
    }

    /** @return mixed[] */
    public function map(callable $callback): array
    {
        return array_values(array_map(
            $callback,
            $this->entities,
        ));
    }

    public function count(): int
    {
        return count($this->entities);
    }

    public function isEmpty(): bool
    {
        return $this->count() < 1;
    }

    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }
}
