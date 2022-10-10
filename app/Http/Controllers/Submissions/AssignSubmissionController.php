<?php

namespace App\Http\Controllers\Submissions;

use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class AssignSubmissionController
{
    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function __invoke(Submission $submission): JsonResponse
    {
        $doctor = request()->user();
        if ($doctor->cannot('SubmissionIsAssignable', $submission)) {
            abort(403);
        }

        $submission->doctor_id = $doctor->id;
        return responder()->success()->respond();
    }
}
