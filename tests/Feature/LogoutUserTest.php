<?php

namespace Tests\Feature;

use App\Models\User;
use App\Transformers\UserTransformer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $this->postJson('/api/logout', $user->toArray())->assertSuccessful();
    }


    public function testLogoutWithoutBeingLoggedIn()
    {
        $this->postJson('/api/logout')->assertStatus(401);
    }

}
