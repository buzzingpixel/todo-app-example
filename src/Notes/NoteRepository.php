<?php

declare(strict_types=1);

namespace App\Notes;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

use App\Authorization\User;
use App\Notes\Persistence\ActionResult;
use App\Notes\Persistence\CreateNote;
use App\Notes\Persistence\DeleteNote;
use App\Notes\Persistence\FindNotes;
use App\Notes\Persistence\NoteRecord;
use App\Notes\Persistence\SaveNote;
use App\Persistence\UuidFactoryWithOrderedTimeCodec;

readonly class NoteRepository
{
    public function __construct(
        private SaveNote $save,
        private FindNotes $find,
        private CreateNote $create,
        private DeleteNote $delete,
        private UuidFactoryWithOrderedTimeCodec $uuidFactory,
    ) {
    }

    public function create(
        string $title,
        string $note,
        User $user,
    ): ActionResult {
        $record = new NoteRecord();

        $record->id = $this->uuidFactory->uuid4()->toString();

        $record->user_id = $user->id->toNative();

        $record->title = $title;

        $record->note = $note;

        return $this->create->create($record);
    }

    public function save(Note $todo): ActionResult
    {
        $record = new NoteRecord();

        $record->id = $todo->id->toNative();

        $record->user_id = $todo->userId->toNative();

        $record->title = $todo->title->toNative();

        $record->note = $todo->note->toNative();

        return $this->save->save($record);
    }

    public function delete(string $id): ActionResult
    {
        return $this->delete->delete($id);
    }

    public function findOne(string|null $idOrUserId = null): Note
    {
        return Note::fromRecord($this->find->findOne(
            $idOrUserId,
        ));
    }

    public function findOneOrNull(string|null $idOrUserId = null): Note|null
    {
        $record = $this->find->findOneOrNull($idOrUserId);

        return $record === null ? null : Note::fromRecord($record);
    }

    public function findAll(string|null $idOrUserId = null): NoteCollection
    {
        $records = $this->find->findAll($idOrUserId);

        /** @phpstan-ignore-next-line */
        return new NoteCollection($records->map(
            static fn (NoteRecord $record) => Note::fromRecord(
                $record,
            ),
        ));
    }
}
