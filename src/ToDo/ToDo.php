<?php

declare(strict_types=1);

namespace App\ToDo;

use App\ToDo\Persistence\ToDoRecord;
use App\ToDo\ValueObjects\Id;
use App\ToDo\ValueObjects\IsDone;
use App\ToDo\ValueObjects\Title;
use App\ToDo\ValueObjects\UserId;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class ToDo
{
    public static function fromRecord(ToDoRecord $record): self
    {
        return new self(
            Id::fromNative($record->id),
            UserId::fromNative($record->user_id),
            Title::fromNative($record->title),
            IsDone::fromNative($record->is_done),
        );
    }

    public function __construct(
        public Id $id,
        public UserId $userId,
        public Title $title,
        public IsDone $isDone,
    ) {
    }
}
