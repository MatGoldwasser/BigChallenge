<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LoginUserCase extends TestCase
{
    use RefreshDatabase;

    public function testLoginSuccess()
    {
        User::factory()->create([
            'email' => 'gian@gmail.com',
            'password' => Hash::make('123456789')
        ]);

        $this->postJson('/api/login', [
            'email' => 'gian@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ])->assertSuccessful();
    }

    public function testWrongPassword()
    {
        User::factory()->create([
            'email' => 'felipe@gmail.com',
            'password' => Hash::make('lightit123')
        ]);

        $this->postJson('/api/login', [
            'email' => 'felipe@gmail.com',
            'password' => 'estaTodoMal',
            'password_confirmation' => 'estaTodoMal'
        ])->assertStatus(401);
    }

    public function testNoPassword()
    {
        User::factory()->create([
            'email' => 'juan@gmail.com',
            'password' => Hash::make('password123')
        ]);

        $this->postJson('/api/login', [
            'email' => 'juan@gmail.com',
        ])->assertStatus(422);
    }

    public function testAlreadyLoggedIn()
    {
        Sanctum::actingAs(
            User::factory()->create([
                'email' => 'prueba@gmail.com',
                'password' => Hash::make('password1')
            ])
        );

        $this->postJson('/api/login', [
            'email' => 'otroEmail@gmail.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ])->assertStatus(401);
    }
}
