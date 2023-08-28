<?php

declare(strict_types=1);

namespace App\Authorization\Persistence;

use App\Persistence\AppPdo;
use PDO;

use function implode;

readonly class FindUserSessions
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function findOne(string|null $id = null): UserSessionRecord
    {
        return $this->findAll($id)->first();
    }

    public function findOneOrNull(
        string|null $id = null,
    ): UserSessionRecord|null {
        return $this->findAll($id)->firstOrNull();
    }

    public function findAll(
        string|null $id = null,
    ): UserSessionRecordCollection {
        $query = [
            'SELECT * FROM',
            UserSessionRecord::getTableName(),
        ];

        $params = [];

        if ($id !== null) {
            $query[] = 'WHERE id = :id';

            $params['id'] = $id;
        }

        $statement = $this->pdo->prepare(
            implode(' ', $query),
        );

        $statement->execute($params);

        $results = $statement->fetchAll(
            PDO::FETCH_CLASS,
            UserSessionRecord::class,
        );

        return new UserSessionRecordCollection(
            $results !== false ? $results : [],
        );
    }
}
