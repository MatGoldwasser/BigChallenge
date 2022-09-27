<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class LogoutUserTest extends TestCase
{
    use RefreshDatabase;

    public function testLogoutSuccess()
    {
        Sanctum::actingAs(
            $user = User::factory()->create([
                'email' => 'sergio@gmail.com',
                'password' => Hash::make('password1')
            ])
        );

        $this->postJson('/api/logout')->assertSuccessful();
    }

    public function testLogoutWithoutBeingLoggedIn()
    {
        $this->postJson('/api/logout')->assertStatus(401);
    }
}
