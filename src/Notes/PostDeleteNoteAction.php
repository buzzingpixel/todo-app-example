<?php

declare(strict_types=1);

namespace App\Notes;

use App\Authorization\UserSession;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;
use function is_array;

readonly class PostDeleteNoteAction
{
    public function __construct(
        private PostResponderFactory $responderFactory,
        private DeleteNoteIfApplicable $deleteNoteIfApplicable,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $session = $request->getAttribute('session');
        assert($session instanceof UserSession);

        $rawPostData = $request->getParsedBody();
        $rawPostData = is_array($rawPostData) ? $rawPostData : [];

        $postData = PostData::createFromArray($rawPostData);

        $result = $this->deleteNoteIfApplicable->delete(
            $postData,
            $session->user(),
        );

        return $this->responderFactory->create($result)->respond();
    }
}
