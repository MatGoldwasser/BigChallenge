<?php

namespace App\Http\Controllers;

use App\Transformers\SubmissionTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GetSubmissionsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $submissions = Auth::user()->submissions;

        return responder()->success($submissions, SubmissionTransformer::class)->respond();
    }
}
