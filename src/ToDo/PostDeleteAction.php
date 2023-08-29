<?php

declare(strict_types=1);

namespace App\ToDo;

use App\Authorization\UserSession;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function assert;
use function is_array;

class PostDeleteAction
{
    public function __construct(
        private ToDoRepository $repository,
        private PostResponderFactory $responderFactory,
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

        $todo = $this->repository->findOne(
            $postData->id->toNative(),
        );

        $result = $this->repository->delete($todo->id->toNative());

        return $this->responderFactory->create($result)->respond(
            $result,
        );
    }
}
