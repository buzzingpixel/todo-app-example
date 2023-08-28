<?php

declare(strict_types=1);

namespace App\Authorization\Persistence;

use RuntimeException;

use function array_map;
use function array_values;
use function count;

class UserSessionRecordCollection
{
    /** @var UserSessionRecord[] */
    public array $records;

    /** @param UserSessionRecord[] $records */
    public function __construct(array $records = [])
    {
        $this->records = array_values(array_map(
            static fn (UserSessionRecord $r) => $r,
            $records,
        ));
    }

    public function first(): UserSessionRecord
    {
        $record = $this->firstOrNull();

        if ($record === null) {
            throw new RuntimeException('No UserSession record found');
        }

        return $record;
    }

    public function firstOrNull(): UserSessionRecord|null
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
