<?php

declare(strict_types=1);

namespace App\Notes;

use App\Notes\Persistence\NoteRecord;
use App\Notes\ValueObjects\Id;
use App\Notes\ValueObjects\Title;
use App\Notes\ValueObjects\UserId;
use Spatie\Cloneable\Cloneable;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class Note
{
    use Cloneable;

    public static function fromRecord(NoteRecord $record): self
    {
        return new self(
            Id::fromNative($record->id),
            UserId::fromNative($record->user_id),
            Title::fromNative($record->title),
            ValueObjects\Note::fromNative($record->note),
        );
    }

    public function __construct(
        public Id $id,
        public UserId $userId,
        public Title $title,
        public ValueObjects\Note $note,
    ) {
    }
}
