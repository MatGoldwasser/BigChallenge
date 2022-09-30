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

    public function testDoctorSubmission()
    {
        (new PermissionSeeder)->run();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'email' => 'felipe@gmail.com',
                'password' => 'password123'
            ])
        );

        $user->assignRole('Doctor');


        $this->postJson('/api/submission', [
            'title' => 'Back pain',
            'symptoms' => fake()->text,
            'other_info' => fake()->text,
            'phone' => fake()->phoneNumber
        ])->assertStatus(403);
    }

    /**
     * @dataProvider invalidInformationSubmission
     */

    public function testSubmissionErrorCases($data)
    {
        (new PermissionSeeder)->run();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'email' => 'felipe@gmail.com',
                'password' => 'password123'
            ])
        );

        $user->assignRole('Patient');

        $this->postJson('/api/submission', $data)->assertStatus(401);
    }


    public function invalidInformationSubmission():array
    {
        return [
          ['no title' => [
              'symptoms' => fake()->text,
              'other_info' => fake()->text,
              'phone' => fake()->phoneNumber
          ]],
            ['no symptoms' => [
                'title' => 'Headache',
                'other_info' => fake()->text,
                'phone' => fake()->phoneNumber
            ]],
            ['no data' => [

            ]]
        ];
    }
}
