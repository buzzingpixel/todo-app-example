<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

readonly class RespondWithSuccess implements Responder
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function respond(
        LogInResult $result,
        PostData $postData,
    ): ResponseInterface {
        return $this->responseFactory->createResponse(303)
            ->withHeader(
                'Location',
                $postData->returnTo->toNative(),
            )
            ->withHeader(
                'Set-Cookie',
                'user_session_id=' . $result->sessionId,
            );
    }
}
