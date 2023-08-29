<?php

declare(strict_types=1);

namespace App\Notes\Persistence;

use App\Persistence\AppPdo;

use function implode;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class SaveNote
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function save(NoteRecord $record): ActionResult
    {
        if ($record->title === '') {
            return new ActionResult(
                false,
                ['Title is required'],
            );
        }

        $statement = $this->pdo->prepare(implode(' ', [
            'UPDATE',
            $record->tableName(),
            'SET',
            'user_id = :user_id, title = :title, note = :note',
            'WHERE id = :id',
        ]));

        $result = $statement->execute([
            ':user_id' => $record->user_id,
            ':title' => $record->title,
            ':note' => $record->note,
            ':id' => $record->id,
        ]);

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
