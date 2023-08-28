<?php

declare(strict_types=1);

namespace App\Authorization;

use App\Authorization\LogIn\GetLogInAction;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class RequireAuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private GetLogInAction $getLoginAction,
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
    ): ResponseInterface {
        $sessionId = $request->getCookieParams()['user_session_id'] ?? null;

        if ($sessionId === null) {
            return ($this->getLoginAction)(
                $request,
                $this->responseFactory->createResponse(),
            );
        }

        $session = $this->userRepository->findSessionById($sessionId);

        if (! $session->isValid()) {
            return ($this->getLoginAction)(
                $request,
                $this->responseFactory->createResponse(),
            );
        }

        return $handler->handle(
            $request->withAttribute('session', $session),
        );
    }
}
