<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;

class GetASubmissionController extends Controller
{
    public function __invoke(Submission $submission): JsonResponse
    {
        return responder()->success(Submission::find($submission))->respond();
    }
}
