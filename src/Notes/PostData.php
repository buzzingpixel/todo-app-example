<?php

declare(strict_types=1);

namespace App\Notes;

use App\ToDo\ValueObjects\Id;

class PostData
{
    /** @param scalar[] $postData */
    public static function createFromArray(array $postData): self
    {
        return new self(Id::fromNative(
            (string) ($postData['id'] ?? ''),
        ));
    }

    public function __construct(public Id $id)
    {
    }
}
