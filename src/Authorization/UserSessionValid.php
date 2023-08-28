<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\ValueObjects\Id;

readonly class UserSessionValid implements UserSession
{
    public function __construct(
        private Id $id,
        private User $user,
    ) {
    }

    public function isValid(): bool
    {
        return true;
    }

    public function sessionId(): Id
    {
        return $this->id;
    }

    public function user(): User
    {
        return $this->user;
    }
}
