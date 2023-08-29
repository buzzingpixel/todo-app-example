<?php

declare(strict_types=1);

namespace App\Notes\Details;

use App\Authorization\UserSession;
use App\Notes\NoteRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;

readonly class GetViewDetailsAction
{
    public function __construct(
        private NoteRepository $repository,
        private GetViewDetailsResponderFactory $responderFactory,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $session = $request->getAttribute('session');
        assert($session instanceof UserSession);

        /** @phpstan-ignore-next-line */
        $noteId = (string) $request->getAttribute('id');
        $noteId = $noteId === '' ?
            // If noteId is empty, use an invalid uuid
            'f4d45581-8254-4af8-893e-1f07c8ffedd9' :
            $noteId;

        return $this->responderFactory->create(
            $request,
            $this->repository->findOne($noteId),
            $session->user(),
        )->respond();
    }
}
