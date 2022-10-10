<?php

namespace App\Policies;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SubmissionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): Response
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model): Response
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): Response
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User       $user
     * @param \App\Models\Submission $submission
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Submission $submission):Response
    {
            return $user->doctor() && ($submission->doctor_id == $user->id || $submission->doctor_id == null)
                ? Response::allow()
                : Response::deny('Not authorized');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model): Response
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, User $model): Response
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user
     * @param \App\Models\User $model
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, User $model): Response
    {
        //
    }
}
