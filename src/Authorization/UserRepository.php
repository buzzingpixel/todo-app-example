<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\Persistence\CreateSession;
use App\Authorization\Persistence\FindUsers;
use App\Authorization\Persistence\FindUserSessions;
use App\Authorization\Persistence\UserRecord;
use App\Authorization\Persistence\UserSessionRecord;
use App\Authorization\ValueObjects\Id;
use App\Persistence\UuidFactoryWithOrderedTimeCodec;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class UserRepository
{
    public function __construct(
        private FindUsers $findUsers,
        private CreateSession $createSession,
        private FindUserSessions $findUserSessions,
        private UuidFactoryWithOrderedTimeCodec $uuidFactory,
    ) {
    }

    public function createSession(User $user): UserSession
    {
        $session = new UserSessionValid(
            new Id($this->uuidFactory->uuid4()),
            $user,
        );

        $record = new UserSessionRecord();

        $record->id = $session->sessionId()->toNative();

        $record->user_id = $session->user()->id->toNative();

        $result = $this->createSession->create($record);

        if (! $result->success) {
            return new UserSessionInvalid();
        }

        return $session;
    }

    public function findSessionById(string|null $session): UserSession
    {
        $session = $this->findUserSessions->findOneOrNull($session);

        if ($session === null) {
            return new UserSessionInvalid();
        }

        $user = $this->findOneOrNull($session->user_id);

        if ($user === null) {
            return new UserSessionInvalid();
        }

        return new UserSessionValid(
            Id::fromNative($session->id),
            $user,
        );
    }

    public function findOne(string|null $idOrEmail = null): User
    {
        return User::fromRecord($this->findUsers->findOne(
            $idOrEmail,
        ));
    }

    public function findOneOrNull(string|null $idOrEmail = null): User|null
    {
        $record = $this->findUsers->findOneOrNull($idOrEmail);

        return $record === null ? null : User::fromRecord($record);
    }

    public function findAll(string|null $idOrEmail = null): UserCollection
    {
        $records = $this->findUsers->findAll($idOrEmail);

        /** @phpstan-ignore-next-line */
        return new UserCollection($records->map(
            static fn (UserRecord $record) => User::fromRecord(
                $record,
            ),
        ));
    }
}
