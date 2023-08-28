<?php

declare(strict_types=1);

namespace App\Authorization\Persistence;

use App\Persistence\Record;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

class UserSessionRecord extends Record
{
    public static function getTableName(): string
    {
        return 'user_sessions';
    }

    public function tableName(): string
    {
        return 'user_sessions';
    }

    public string $id = '';

    public string $user_id = '';
}
