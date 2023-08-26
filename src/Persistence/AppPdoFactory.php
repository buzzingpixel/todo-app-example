<?php

declare(strict_types=1);

namespace App\Persistence;

use PDO;

class AppPdoFactory
{
    public function create(): AppPdo
    {
        return new AppPdo(
            'sqlite:' . __DIR__ . '/sqlite.db',
            options: [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ],
        );
    }
}
