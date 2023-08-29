<?php

declare(strict_types=1);

namespace App\Notes\Details;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpNotFoundException;

class GetViewDetailsRespondWithNotFound implements GetViewDetailsResponder
{
    private ServerRequestInterface $request;

    public function withRequest(ServerRequestInterface $request): static
    {
        $clone = clone $this;

        $clone->request = $request;

        return $clone;
    }

    public function respond(): ResponseInterface
    {
        throw new HttpNotFoundException($this->request);
    }
}
