<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\ValueObjects\Id;

interface UserSession
{
    public function isValid(): bool;

    public function sessionId(): Id;

    public function user(): User;
}
