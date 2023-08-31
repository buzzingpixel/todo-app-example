<?php

declare(strict_types=1);

namespace App\Notes;

use App\Notes\Persistence\ActionResult;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

use function implode;

class PostRespondWithError implements PostResponder
{
    private ActionResult $result;

    public function withResult(ActionResult $result): static
    {
        $clone = clone $this;

        $clone->result = $result;

        return $clone;
    }

    public function respond(): ResponseInterface
    {
        throw new RuntimeException(
            implode(',', $this->result->message),
        );
    }
}
