<?php

declare(strict_types=1);

namespace App\Notes\Add;

use App\Notes\Persistence\ActionResult;
use Psr\Http\Message\ResponseInterface;

interface PostResponder
{
    public function respond(ActionResult $result): ResponseInterface;
}
