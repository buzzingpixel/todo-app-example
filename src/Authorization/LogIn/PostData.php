<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

use App\Authorization\LogIn\ValueObjects\Email;
use App\Authorization\LogIn\ValueObjects\Password;
use App\Authorization\ValueObjects\ReturnTo;

readonly class PostData
{
    /** @param scalar[] $postData */
    public static function createFromArray(array $postData): self
    {
        return new self(
            Email::fromNative(
                (string) ($postData['email'] ?? ''),
            ),
            Password::fromNative(
                (string) ($postData['password'] ?? ''),
            ),
            ReturnTo::fromNative(
                (string) ($postData['return_to'] ?? ''),
            ),
        );
    }

    public function __construct(
        public Email $email,
        public Password $password,
        public ReturnTo $returnTo,
    ) {
    }
}
