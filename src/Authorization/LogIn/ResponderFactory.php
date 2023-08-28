<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

readonly class ResponderFactory
{
    public function __construct(
        private RespondWithError $error,
        private RespondWithSuccess $success,
    ) {
    }

    public function create(LogInResult $result): Responder
    {
        if (! $result->loggedIn) {
            return $this->error;
        }

        return $this->success;
    }
}
