<?php

declare(strict_types=1);

namespace App\ToDo\Persistence;

use App\Persistence\Record;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

class ToDoRecord extends Record
{
    public static function getTableName(): string
    {
        return 'todos';
    }

    public function tableName(): string
    {
        return 'todos';
    }

    public string $id = '';

    public string $title = '';

    public bool $is_done = false;
}
