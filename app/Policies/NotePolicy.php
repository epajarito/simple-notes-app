<?php

namespace App\Policies;

use App\Models\{Note, User};
use Illuminate\Database\Eloquent\Model;

class NotePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Note $note): bool
    {
        return $this->canAccessModel($note, $user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Note $note): bool
    {
        return $this->canAccessModel($note, $user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Note $note): bool
    {
        return $this->canAccessModel($note, $user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Note $note): bool
    {
        return $this->canAccessModel($note, $user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Note $note): bool
    {
        return $this->canAccessModel($note, $user);
    }

    private function canAccessModel(Model $model, User $user): bool
    {
        return $model->user_id == $user->id;
    }
}
