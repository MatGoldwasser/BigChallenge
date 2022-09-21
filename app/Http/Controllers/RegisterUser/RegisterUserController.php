<?php

namespace App\Http\Controllers\RegisterUser;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Models\User;

class RegisterUserController extends Controller
{

    public function __invoke(CreateUserRequest $request)
    {
        User::create([
           'name' => $request->name,
           'email' => $request->email,
           'password' => $request->password
        ]);

    }
}
