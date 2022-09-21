<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    use RefreshDatabase;

    public function testRegisterSuccess()
    {
        $this->postJson('/api/register', [
            'name' => 'Mateo',
            'email' => 'mateo@hotmail.com',
            'password' => '123456789mm',
            'password_confirmation' => '123456789mm'
        ])->assertSuccessful();

        $this->assertDatabaseCount('users', 1);
    }

    public function testExistingEmail()
    {
        User::factory()->create(['email' => 'mateo@hotmail.com']);

        $this->postJson('/api/register', [
            'name' => 'Felipe',
            'email' => 'mateo@hotmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ])->assertStatus(422);

        $this->assertDatabaseCount('users', 1);
    }



    /**
     * @dataProvider invalidInformationRegisterUser
     */

    public function testRegisterErrorCases($data)
    {
        $this->postJson('/api/register', $data)->assertStatus(422);
    }

    public function invalidInformationRegisterUser()
    {
        return [
            ['no name' => [
                'email' => 'British Hospital',
                'password' => 'mipassword123',
                'password_confirmation' => 'mipassword123'
            ]],
            ['numeric name' => [
                'name' => 'Felipe34',
                'email' => 'juegoAlLol@gmail.com',
                'password' => 'lolismylife',
                'password_confirmation' => 'lolismylife'
            ]],
            ['no email' => [
                'name' => 'Felipe34',
                'password' => 'lolismylife',
                'password_confirmation' => 'lolismylife'
            ]],
            ['email not valid' => [
                'name' => 'Felipe34',
                'email' => 'estoNoEsUnMail',
                'password' => 'lolismylife',
                'password_confirmation' => 'lolismylife'
            ]],
            ['incorrect confirmed password' => [
                'name' => 'Felipe34',
                'email' => 'juegoAlLol@gmail.com',
                'password' => 'password1',
                'password_confirmation' => 'password2'
            ]]
        ];
    }
}
