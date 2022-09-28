<?php

namespace App\Http\Controllers\LogoutUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutUserController
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return responder()->success()->respond();
    }
}
