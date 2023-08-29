<?php

declare(strict_types=1);

namespace App\ToDo\Add;

use App\ToDo\Persistence\ActionResult;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

readonly class PostRespondWithSuccess implements PostResponder
{
    public function __construct(
        private ResponseFactoryInterface $responseFactory,
    ) {
    }

    public function respond(ActionResult $result): ResponseInterface
    {
        return $this->responseFactory->createResponse(303)->withHeader(
            'Location',
            '/todos',
        );
    }
}
