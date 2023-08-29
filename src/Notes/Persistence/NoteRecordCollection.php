<?php

declare(strict_types=1);

namespace App\Notes\Persistence;

use RuntimeException;

use function array_map;
use function array_values;
use function count;

class NoteRecordCollection
{
    /** @var NoteRecord[] */
    public array $records;

    /** @param NoteRecord[] $records */
    public function __construct(array $records = [])
    {
        $this->records = array_values(array_map(
            static fn (NoteRecord $r) => $r,
            $records,
        ));
    }

    public function first(): NoteRecord
    {
        $record = $this->firstOrNull();

        if ($record === null) {
            throw new RuntimeException('No Note record found');
        }

        return $record;
    }

    public function firstOrNull(): NoteRecord|null
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
