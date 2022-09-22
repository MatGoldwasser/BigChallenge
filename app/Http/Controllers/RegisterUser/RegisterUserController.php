<?php

namespace App\Http\Controllers\RegisterUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class RegisterUserController extends Controller
{
    public function __invoke(CreateUserRequest $request):JsonResponse
    {
        User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'message' => 'User successfully created'
        ], 200);
    }
}
