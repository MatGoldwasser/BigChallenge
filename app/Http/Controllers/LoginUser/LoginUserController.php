<?php

namespace App\Http\Controllers\LoginUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class LoginUserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(LoginUserRequest $request):JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return responder()->error()->respond(401, ['message' => 'Login invalid']);
        }

        return responder()->success($user, UserTransformer::class)->respond();
    }
}
