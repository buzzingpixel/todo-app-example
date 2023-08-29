<?php

declare(strict_types=1);

namespace App\Persistence;

use RuntimeException;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

abstract class Record
{
    abstract public static function getTableName(): string;

    abstract public function tableName(): string;

    /**
     * Ensure all columns are explicitly declared on the record. If we change
     * a column name, we'll get an exception when PDO tries to populate this
     */
    public function __set(string $name, mixed $value): void
    {
        throw new RuntimeException(
            'Property ' . $name . ' must be declared explicitly',
        );
    }
}
