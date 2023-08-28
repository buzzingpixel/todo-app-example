<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Persistence\UserRecord;
use App\Authorization\ValueObjects\Email;
use App\Authorization\ValueObjects\Id;
use App\Authorization\ValueObjects\Name;
use App\Authorization\ValueObjects\PasswordHash;

use function password_verify;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class User
{
    public static function fromRecord(UserRecord $record): self
    {
        return new self(
            Id::fromNative($record->id),
            Email::fromNative($record->email),
            Name::fromNative($record->name),
            PasswordHash::fromNative(
                $record->password_hash,
            ),
        );
    }

    public function __construct(
        public Id $id,
        public Email $email,
        public Name $name,
        public PasswordHash $passwordHash,
    ) {
    }

    public function passwordIsValid(string $password): bool
    {
        return password_verify(
            $password,
            $this->passwordHash->toNative(),
        );
    }
}
