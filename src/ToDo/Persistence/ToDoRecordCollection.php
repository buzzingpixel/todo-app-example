<?php

declare(strict_types=1);

namespace App\ToDo\Persistence;

use RuntimeException;

use function array_map;
use function array_values;
use function count;

class ToDoRecordCollection
{
    /** @var ToDoRecord[] */
    public array $records;

    /** @param ToDoRecord[] $records */
    public function __construct(array $records = [])
    {
        $this->records = array_values(array_map(
            static fn (ToDoRecord $r) => $r,
            $records,
        ));
    }

    public function first(): ToDoRecord
    {
        $record = $this->firstOrNull();

        if ($record === null) {
            throw new RuntimeException('No ToDo record found');
        }

        return $record;
    }

    public function firstOrNull(): ToDoRecord|null
    {
        return $this->records[0] ?? null;
    }

    /** @return mixed[] */
    public function map(callable $callback): array
    {
        return array_values(array_map(
            $callback,
            $this->records,
        ));
    }

    public function count(): int
    {
        return count($this->records);
    }
}
