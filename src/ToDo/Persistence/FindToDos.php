<?php

declare(strict_types=1);

namespace App\ToDo\Persistence;

use App\Persistence\AppPdo;
use PDO;

use function implode;

readonly class FindToDos
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function findOne(string|null $idOrUserId = null): ToDoRecord
    {
        return $this->findAll($idOrUserId)->first();
    }

    public function findOneOrNull(
        string|null $idOrUserId = null,
    ): ToDoRecord|null {
        return $this->findAll($idOrUserId)->firstOrNull();
    }

    public function findAll(
        string|null $idOrUserId = null,
    ): ToDoRecordCollection {
        $query = [
            'SELECT * FROM',
            ToDoRecord::getTableName(),
        ];

        $params = [];

        if ($idOrUserId !== null) {
            $query[] = 'WHERE id = :id OR user_id = :id';

            $params['id'] = $idOrUserId;
        }

        $statement = $this->pdo->prepare(
            implode(' ', $query),
        );

        $statement->execute($params);

        $results = $statement->fetchAll(
            PDO::FETCH_CLASS,
            ToDoRecord::class,
        );

        return new ToDoRecordCollection(
            $results !== false ? $results : [],
        );
    }
}
