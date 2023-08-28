<?php

declare(strict_types=1);

namespace App\Authorization\Persistence;

use App\Persistence\AppPdo;
use PDO;

use function implode;

readonly class FindUsers
{
    public function __construct(private AppPdo $pdo)
    {
    }

    public function findOne(string|null $idOrEmail = null): UserRecord
    {
        return $this->findAll($idOrEmail)->first();
    }

    public function findOneOrNull(string|null $idOrEmail = null): UserRecord|null
    {
        return $this->findAll($idOrEmail)->firstOrNull();
    }

    public function findAll(string|null $idOrEmail = null): UserRecordCollection
    {
        $query = [
            'SELECT * FROM',
            UserRecord::getTableName(),
        ];

        $params = [];

        if ($idOrEmail !== null) {
            $query[] = 'WHERE id = :idOrEmail OR email = :idOrEmail';

            $params['idOrEmail'] = $idOrEmail;
        }

        $statement = $this->pdo->prepare(
            implode(' ', $query),
        );

        $statement->execute($params);

        $results = $statement->fetchAll(
            PDO::FETCH_CLASS,
            UserRecord::class,
        );

        return new UserRecordCollection(
            $results !== false ? $results : [],
        );
    }
}
