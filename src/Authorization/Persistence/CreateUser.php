<?php

declare(strict_types=1);

namespace App\Authorization\Persistence;

use App\Persistence\AppPdo;

use function count;
use function implode;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class CreateUser
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function create(UserRecord $record): ActionResult
    {
        $error = [];

        if ($record->email === '') {
            $error[] = 'Email is required';
        }

        if ($record->name === '') {
            $error[] = 'Name is required';
        }

        if ($record->password_hash === '') {
            $error[] = 'Name is required';
        }

        if (count($error) > 0) {
            return new ActionResult(
                false,
                $error,
            );
        }

        $statement = $this->pdo->prepare(implode(' ', [
            'INSERT INTO',
            $record->tableName(),
            '(id, email, name, password_hash)',
            'VALUES',
            '(:id, :email, :name, :password_hash)',
        ]));

        $result = $statement->execute([
            'id' => $record->id,
            'email' => $record->email,
            'name' => $record->name,
            'password_hash' => $record->password_hash,
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
