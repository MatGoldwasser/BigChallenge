<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Requests\CreateSubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CreateSubmissionController
{
    public function __invoke(CreateSubmissionRequest $request): JsonResponse
    {
        $submission = Submission::create([
            'title' => $request->title,
            'symptoms' => $request->symptoms,
            'other_info' => $request->other_info,
            'phone' => $request->phone,
            'status' => $request->status,
            'patient_id' => $request->user()
        ]);

        return responder()->success()->respond(200, [
            'title' => $submission->title,
            'symptoms' => $submission->symptoms,
            'other_info' => $submission->other_info,
            'phone' => $submission->phone
        ]);
    }
}
