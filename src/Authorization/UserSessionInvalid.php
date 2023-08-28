<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\ValueObjects\Id;
use RuntimeException;

class UserSessionInvalid implements UserSession
{
    public function isValid(): bool
    {
        return false;
    }

    public function sessionId(): Id
    {
        throw new RuntimeException('Invalid session');
    }

    public function user(): User
    {
        throw new RuntimeException('Invalid session');
    }
}
