<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Requests\SubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class SubmissionController
{

    public function __invoke(SubmissionRequest $request): JsonResponse
    {
        $submission = Submission::create([
            'title' => $request->title,
            'symptoms' => $request->symptoms,
            'other_info' => $request->other_info,
            'phone' => $request->phone
        ]);

        return responder()->success()->respond(200, [
            'title' => $submission->title,
            'symptoms' => $submission->symptoms,
            'other_info' => $submission->other_info,
            'phone' => $submission->phone
        ]);
    }
}
