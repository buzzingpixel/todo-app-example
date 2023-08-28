<?php

declare(strict_types=1);

namespace App\Authorization\Persistence;

use App\Persistence\AppPdo;

use function implode;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class CreateSession
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function create(UserSessionRecord $record): ActionResult
    {
        $statement = $this->pdo->prepare(implode(' ', [
            'INSERT INTO',
            $record->tableName(),
            '(id, user_id)',
            'VALUES',
            '(:id, :user_id)',
        ]));

        $result = $statement->execute([
            'id' => $record->id,
            'user_id' => $record->user_id,
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
