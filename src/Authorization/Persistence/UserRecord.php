<?php

declare(strict_types=1);

namespace App\Authorization\Persistence;

use App\Persistence\Record;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

class UserRecord extends Record
{
    public static function getTableName(): string
    {
        return 'users';
    }

    public function tableName(): string
    {
        return 'users';
    }

    public string $id = '';

    public string $email = '';

    public string $name = '';

    public string $password_hash = '';
}
