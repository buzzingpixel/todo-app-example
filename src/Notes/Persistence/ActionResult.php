<?php

declare(strict_types=1);

namespace App\Notes\Persistence;

use function implode;

use const PHP_EOL;

class ActionResult
{
    /** @param string[] $message */
    public function __construct(
        public bool $success = true,
        public array $message = [],
        public int|string $errorCode = '',
    ) {
    }

    public function messageAsString(string $separator = PHP_EOL): string
    {
        return implode($separator, $this->message);
    }
}
