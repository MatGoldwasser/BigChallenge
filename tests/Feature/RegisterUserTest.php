<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_success()
    {
        $this->postJson('/api/register', [
            'name'=>'Mateo',
            'email' => 'mateo@hotmail.com',
            'password' => '123456789'
        ])->assertSuccessful();
    }


    /**
     * @dataProvider invalidInformationRegisterUser
     */

    public function test_register_error_cases($data)
    {
        $this->postJson('/api/register', $data)->assertStatus(422);
    }

    public function invalidInformationRegisterUser()
    {
        return [
            ['no name'=>[
                'email'=>'British Hospital',
                'password' => 'mipassword123',
                'password_confirmed' => 'mipassword123'
            ]],
            ['numeric name'=>[
                'name'=>'Felipe34',
                'email'=>'juegoAlLol@gmail.com',
                'password'=> 'lolismylife',
                'password_confirmed' => 'lolismylife'
            ]],
            ['no email'=>[
                'name'=>'Felipe34',
                'password'=> 'lolismylife',
                'password_confirmed' => 'lolismylife'
            ]],
            ['email not valid'=>[
                'name'=>'Felipe34',
                'email'=>'estoNoEsUnMail',
                'password'=> 'lolismylife',
                'password_confirmed' => 'lolismylife'
            ]],
            ['incorrect confirmed password'=>[
                'name'=>'Felipe34',
                'email'=>'juegoAlLol@gmail.com',
                'password'=> 'password1',
                'password_confirmed' => 'password2'
            ]]
        ];
    }
}
