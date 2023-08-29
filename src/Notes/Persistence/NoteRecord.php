<?php

declare(strict_types=1);

namespace App\Notes\Persistence;

use App\Persistence\Record;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

class NoteRecord extends Record
{
    public static function getTableName(): string
    {
        return 'notes';
    }

    public function tableName(): string
    {
        return 'notes';
    }

    public string $id = '';

    public string $user_id = '';

    public string $title = '';

    public string $note = '';
}
