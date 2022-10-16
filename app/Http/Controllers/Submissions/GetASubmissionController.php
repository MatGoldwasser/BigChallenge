<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetASubmissionController extends Controller
{

    public function __invoke(Submission $submission):JsonResponse
    {
        return responder()->success($submission)->respond();
    }
}
