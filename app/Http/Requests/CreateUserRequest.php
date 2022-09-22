<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules():array
    {
        return [
            'name' => 'required|alpha',
            'email' => 'required|email:strict|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ];
    }
}
