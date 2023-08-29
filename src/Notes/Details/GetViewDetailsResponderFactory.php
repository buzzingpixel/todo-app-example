<?php

declare(strict_types=1);

namespace App\Notes\Details;

use App\Authorization\User;
use App\Notes\Note;
use Psr\Http\Message\ServerRequestInterface;

readonly class GetViewDetailsResponderFactory
{
    public function __construct(
        private GetViewDetailsRespondWithNote $respondWithNote,
        private GetViewDetailsRespondWithNotFound $respondWithNotFound,
    ) {
    }

    public function create(
        ServerRequestInterface $request,
        Note|null $note,
        User $user,
    ): GetViewDetailsResponder {
        if ($note === null) {
            return $this->respondWithNotFound->withRequest($request);
        }

        if (! $note->userId->isSame($user->id)) {
            return $this->respondWithNotFound->withRequest($request);
        }

        return $this->respondWithNote->withNote($note);
    }
}
