<?php

declare(strict_types=1);

namespace App\Persistence;

use RuntimeException;

use function array_keys;
use function get_object_vars;
use function implode;
use function in_array;
use function is_bool;

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

    /** @return array<string, mixed> */
    public function asArray(): array
    {
        return get_object_vars($this);
    }

    /** @return array<string, mixed> */
    public function asParametersArray(): array
    {
        $array = $this->asArray();

        foreach ($array as $key => $value) {
            if (! is_bool($value)) {
                continue;
            }

            $array[$key] = $value ? '1' : '0';
        }

        return $array;
    }

    /** @return array<string, string> */
    public function columns(string $prefix = ''): array
    {
        $properties = get_object_vars($this);

        $columns = [];

        foreach (array_keys($properties) as $property) {
            $columns[$property] = $prefix . $property;
        }

        return $columns;
    }

    public function columnsAsInsertIntoString(): string
    {
        return '(' . implode(', ', $this->columns()) . ')';
    }

    public function columnsAsValuePlaceholders(): string
    {
        return '(' .
            implode(', ', $this->columns(':')) .
            ')';
    }

    /** @param string[] $exclude */
    public function columnsAsUpdateSetPlaceholders(
        array $exclude = ['id'],
    ): string {
        $value = [];

        foreach ($this->columns() as $column) {
            if (in_array($column, $exclude, true)) {
                continue;
            }

            $value[] = $column . ' = :' . $column;
        }

        return implode(', ', $value);
    }
}
