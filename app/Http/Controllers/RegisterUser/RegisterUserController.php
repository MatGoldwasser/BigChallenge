<?php

namespace App\Http\Controllers\RegisterUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RegisterUserController extends Controller
{
    public function __invoke(CreateUserRequest $request): JsonResponse
    {

      $user =  User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => Hash::make($request->password)
        ]);

        $user->assignRole($request->role);

        return response()->json([
            'message' => 'User successfully created'
        ], 200);
    }
}
