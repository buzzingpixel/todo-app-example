<?php

declare(strict_types=1);

namespace App\Notes;

use Psr\Http\Message\ResponseInterface;

interface PostResponder
{
    public function respond(): ResponseInterface;
}
