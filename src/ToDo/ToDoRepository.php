<?php

declare(strict_types=1);

namespace App\ToDo;

use App\Authorization\User;
use App\Persistence\UuidFactoryWithOrderedTimeCodec;
use App\ToDo\Persistence\ActionResult;
use App\ToDo\Persistence\CreateToDo;
use App\ToDo\Persistence\FindToDos;
use App\ToDo\Persistence\ToDoRecord;

// phpcs:disable Squiz.NamingConventions.ValidVariableName.MemberNotCamelCaps

readonly class ToDoRepository
{
    public function __construct(
        private FindToDos $find,
        private CreateToDo $create,
        private UuidFactoryWithOrderedTimeCodec $uuidFactory,
    ) {
    }

    public function create(string $title, User $user): ActionResult
    {
        $record = new ToDoRecord();

        $record->id = $this->uuidFactory->uuid4()->toString();

        $record->user_id = $user->id->toNative();

        $record->title = $title;

        return $this->create->create($record);
    }

    public function findOne(string|null $idOrUserId = null): ToDo
    {
        return ToDo::fromRecord($this->find->findOne($idOrUserId));
    }

    public function findOneOrNull(string|null $idOrUserId = null): ToDo|null
    {
        $record = $this->find->findOneOrNull($idOrUserId);

        return $record === null ? null : ToDo::fromRecord($record);
    }

    public function findAll(string|null $idOrUserId = null): ToDoCollection
    {
        $records = $this->find->findAll($idOrUserId);

        /** @phpstan-ignore-next-line */
        return new ToDoCollection($records->map(
            static fn (ToDoRecord $record) => ToDo::fromRecord(
                $record,
            ),
        ));
    }
}
