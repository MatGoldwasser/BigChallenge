<?php

namespace App\Http\Controllers\Submissions;

use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetSubmissionsController
{
    public function __invoke(): JsonResponse
    {
        $submissions = Auth::user()->submissions;

        return responder()->success($submissions, SubmissionTransformer::class)->respond();
    }
}
