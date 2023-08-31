<?php

declare(strict_types=1);

namespace App\ToDo;

use App\Authorization\User;
use App\ToDo\Persistence\ActionResult;
use App\ToDo\ValueObjects\IsDone;

readonly class MarkDoneIfApplicable
{
    public function __construct(private ToDoRepository $repository)
    {
    }

    public function mark(
        PostData $postData,
        User $user,
    ): ActionResult {
        $todo = $this->repository->findOneOrNull(
            $postData->id->toNative(),
        );

        if ($todo === null) {
            return new ActionResult(
                false,
                ['Invalid ToDo'],
            );
        }

        if (! $todo->userId->isSame($user->id)) {
            return new ActionResult(
                false,
                ['Invalid ToDo'],
            );
        }

        return $this->repository->save($todo->with(
            isDone: IsDone::fromNative(true),
        ));
    }
}
