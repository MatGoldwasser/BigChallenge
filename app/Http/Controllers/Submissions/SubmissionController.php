<?php

namespace App\Http\Controllers\Submissions;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionRequest;
use App\Models\Submission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubmissionController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(SubmissionRequest $request):JsonResponse
    {
        Submission::create([
            'title' => $request->title,
            'symptoms' => $request->symptoms,
            'other_info' => $request->other_info,
            'phone' => $request->phone
        ]);

        return responder()->success()->respond(200, ['message' => 'Success']);


    }
}
