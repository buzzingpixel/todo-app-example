<?php

declare(strict_types=1);

namespace App\ToDo;

use App\ToDo\Persistence\ActionResult;
use Psr\Http\Message\ResponseInterface;

interface PostResponder
{
    public function respond(ActionResult $result): ResponseInterface;
}
