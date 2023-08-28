<?php

declare(strict_types=1);

namespace App\Authorization\LogIn;

use Psr\Http\Message\ResponseInterface;

interface Responder
{
    public function respond(
        LogInResult $result,
        PostData $postData,
    ): ResponseInterface;
}
