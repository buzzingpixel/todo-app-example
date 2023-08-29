<?php

declare(strict_types=1);

namespace App\Notes\Details;

use Psr\Http\Message\ResponseInterface;

interface GetViewDetailsResponder
{
    public function respond(): ResponseInterface;
}
