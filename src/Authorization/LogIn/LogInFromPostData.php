<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

use App\Authorization\UserRepository;

readonly class LogInFromPostData
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function logIn(PostData $postData): LogInResult
    {
        $user = $this->userRepository->findOneOrNull(
            $postData->email->toNative(),
        );

        if ($user === null) {
            return $this->createBadLogInResult();
        }

        if (
            ! $user->passwordIsValid(
                $postData->password->toNative(),
            )
        ) {
            return $this->createBadLogInResult();
        }

        $session = $this->userRepository->createSession($user);

        if (! $session->isValid()) {
            return $this->createBadLogInResult();
        }

        return new LogInResult(
            true,
            $session->sessionId()->toNative(),
        );
    }

    private function createBadLogInResult(): LogInResult
    {
        return new LogInResult(
            false,
            message: 'Unable to log in with those credentials',
        );
    }
}
