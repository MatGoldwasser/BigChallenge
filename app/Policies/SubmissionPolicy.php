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
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User       $user
     * @param \App\Models\Submission $submission
     *
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function SubmissionIsAssignable(User $user, Submission $submission):Response
    {
            return $user->isDoctor() && ($submission->doctor_id == $user->id || $submission->doctor_id == null)
                ? Response::allow()
                : Response::deny('Not authorized');
    }
}
