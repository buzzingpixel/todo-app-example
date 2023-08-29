<?php

declare(strict_types=1);

namespace App\Notes\Add;

use App\Notes\ValueObjects\Note;
use App\ToDo\ValueObjects\Title;

readonly class PostData
{
    /** @param scalar[] $postData */
    public static function createFromArray(array $postData): self
    {
        return new self(
            Title::fromNative(
                (string) ($postData['title'] ?? ''),
            ),
            Note::fromNative(
                (string) ($postData['note'] ?? ''),
            ),
        );
    }

    public function __construct(
        public Title $title,
        public Note $note,
    ) {
    }
}
