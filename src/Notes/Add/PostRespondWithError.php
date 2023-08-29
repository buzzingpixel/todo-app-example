<?php

declare(strict_types=1);

namespace App\Notes\Add;

use App\Notes\Persistence\ActionResult;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

use function implode;

class PostRespondWithError implements PostResponder
{
    public function respond(ActionResult $result): ResponseInterface
    {
        throw new RuntimeException(
            implode(',', $result->message),
        );
    }
}
