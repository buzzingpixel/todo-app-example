<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

readonly class LogInResult
{
    public function __construct(
        public bool $loggedIn,
        public string $sessionId = '',
        public string $message = '',
    ) {
    }
}
