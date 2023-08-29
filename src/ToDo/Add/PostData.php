<?php

declare(strict_types=1);

namespace App\ToDo\Add;

use App\ToDo\ValueObjects\Title;

readonly class PostData
{
    /** @param scalar[] $postData */
    public static function createFromArray(array $postData): self
    {
        return new self(Title::fromNative(
            (string) ($postData['title'] ?? ''),
        ));
    }

    public function __construct(public Title $title)
    {
    }
}
