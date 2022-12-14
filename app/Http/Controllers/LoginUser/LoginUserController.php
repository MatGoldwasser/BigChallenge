<?php

namespace App\Http\Controllers\LoginUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginUserController extends Controller
{
    public function __invoke(LoginUserRequest $request): JsonResponse
    {
        if (!Auth::check()) {
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return responder()->error()->respond(401, ['message' => 'Login invalid']);
            }

            $user->createToken('token-' . $user->id);
            return responder()->success($user, UserTransformer::class)->respond();
        }

        return responder()->error()->respond(401, ['message' => 'Already logged in']);
    }
}
