<?php

namespace App\Http\Controllers\LogoutUser;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LogoutUserController
{
    public function __invoke(): JsonResponse
    {
        Auth::user()->currentAccessToken()->delete();

        return responder()->success()->respond();
    }
}
