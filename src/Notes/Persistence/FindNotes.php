<?php

declare(strict_types=1);

namespace App\Notes\Persistence;

use App\Persistence\AppPdo;
use PDO;

use function implode;

readonly class FindNotes
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function findOne(string|null $idOrUserId = null): NoteRecord
    {
        return $this->findAll($idOrUserId)->first();
    }

    public function findOneOrNull(
        string|null $idOrUserId = null,
    ): NoteRecord|null {
        return $this->findAll($idOrUserId)->firstOrNull();
    }

    public function findAll(
        string|null $idOrUserId = null,
    ): NoteRecordCollection {
        $query = [
            'SELECT * FROM',
            NoteRecord::getTableName(),
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
            NoteRecord::class,
        );

        return new NoteRecordCollection(
            $results !== false ? $results : [],
        );
    }
}
