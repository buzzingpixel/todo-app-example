<?php

declare(strict_types=1);

namespace App\ToDo\Persistence;

use App\Persistence\AppPdo;

use function implode;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

class CreateToDo
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function create(ToDoRecord $record): ActionResult
    {
        $statement = $this->pdo->prepare(implode(' ', [
            'INSERT INTO',
            $record->tableName(),
            '(id, user_id, title, is_done)',
            'VALUES',
            '(:id, :user_id, :title, :is_done)',
        ]));

        $result = $statement->execute([
            'id' => $record->id,
            'user_id' => $record->user_id,
            'title' => $record->title,
            'is_done' => $record->is_done,
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
