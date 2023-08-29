<?php

declare(strict_types=1);

namespace App\Notes\Persistence;

use App\Persistence\AppPdo;

use function implode;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class CreateNote
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function create(NoteRecord $record): ActionResult
    {
        if ($record->title === '') {
            return new ActionResult(
                false,
                ['Title is required'],
            );
        }

        $statement = $this->pdo->prepare(implode(' ', [
            'INSERT INTO',
            $record->tableName(),
            '(id, user_id, title, note)',
            'VALUES',
            '(:id, :user_id, :title, :note)',
        ]));

        $result = $statement->execute([
            'id' => $record->id,
            'user_id' => $record->user_id,
            'title' => $record->title,
            'note' => $record->note,
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
