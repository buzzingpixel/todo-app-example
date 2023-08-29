<?php

declare(strict_types=1);

namespace App\ToDo\Add;

use App\ToDo\Persistence\ActionResult;

readonly class PostResponderFactory
{
    public function __construct(
        private PostRespondWithError $error,
        private PostRespondWithSuccess $success,
    ) {
    }

    public function create(ActionResult $result): PostResponder
    {
        if (! $result->success) {
            return $this->error;
        }

        return $this->success;
    }
}
