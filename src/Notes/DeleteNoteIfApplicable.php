<?php

declare(strict_types=1);

namespace App\Notes;

use App\Authorization\User;
use App\Notes\Persistence\ActionResult;

readonly class DeleteNoteIfApplicable
{
    public function __construct(private NoteRepository $repository)
    {
    }

    public function delete(
        PostData $postData,
        User $user,
    ): ActionResult {
        $note = $this->repository->findOneOrNull(
            $postData->id->toNative(),
        );

        if ($note === null) {
            return new ActionResult(
                false,
                ['Invalid note'],
            );
        }

        if (! $note->userId->isSame($user->id)) {
            return new ActionResult(
                false,
                ['Invalid note'],
            );
        }

        return $this->repository->delete($note->id->toNative());
    }
}
