<?php

declare(strict_types=1);

namespace App\Authorization;

use RuntimeException;

use function array_map;
use function array_values;

class UserCollection
{
    /** @var User[] */
    public array $entities;

    /** @param User[] $entities */
    public function __construct(array $entities = [])
    {
        $this->entities = array_values(array_map(
            static fn (User $e) => $e,
            $entities,
        ));
    }

    public function first(): User
    {
        $entity = $this->firstOrNull();

        if ($entity === null) {
            throw new RuntimeException('No User found');
        }

        return $entity;
    }

    public function firstOrNull(): User|null
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
}
