<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testSubmissionSuccess()
    {

        (new PermissionSeeder)->run();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'email' => 'felipe@gmail.com',
                'password' => 'password123'
            ])
        );

        $user->assignRole('Patient');


        $this->postJson('/api/submission', [
            'title' => 'Back pain',
            'symptoms' => fake()->text,
            'other_info' => fake()->text,
            'phone' => fake()->phoneNumber
        ])->assertSuccessful();

    }
}
