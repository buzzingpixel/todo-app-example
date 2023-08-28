<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use function is_array;

readonly class PostLoginAction
{
    public function __construct(
        private ResponderFactory $responderFactory,
        private LogInFromPostData $logInFromPostData,
    ) {
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
    ): ResponseInterface {
        $rawPostData = $request->getParsedBody();
        $rawPostData = is_array($rawPostData) ? $rawPostData : [];

        $postData = PostData::createFromArray($rawPostData);

        $result = $this->logInFromPostData->logIn($postData);

        return $this->responderFactory->create($result)->respond(
            $result,
            $postData,
        );
    }
}
