<?php

declare(strict_types=1);

namespace App\Notes\Persistence;

use App\Persistence\AppPdo;

use function implode;

readonly class DeleteNote
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function delete(string $id): ActionResult
    {
        $statement = $this->pdo->prepare(implode(' ', [
            'DELETE FROM',
            NoteRecord::getTableName(),
            'WHERE id = :id',
        ]));

        $result = $statement->execute([':id' => $id]);

        if (! $result) {
            return new ActionResult(
                false,
                $this->pdo->errorInfo(),
                $this->pdo->errorCode(),
            );
        }

        return new ActionResult();
    }
}
