<?php

declare(strict_types=1);

namespace App\Notes;

use RuntimeException;

use function array_map;
use function array_values;
use function count;

readonly class NoteCollection
{
    /** @var Note[] */
    public array $entities;

    /** @param Note[] $entities */
    public function __construct(array $entities = [])
    {
        $this->entities = array_values(array_map(
            static fn (Note $e) => $e,
            $entities,
        ));
    }

    public function first(): Note
    {
        $entity = $this->firstOrNull();

        if ($entity === null) {
            throw new RuntimeException('No Note found');
        }

        return $entity;
    }

    public function firstOrNull(): Note|null
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
