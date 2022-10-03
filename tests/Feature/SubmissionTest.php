<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class SubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testSubmissionSuccess()
    {
        Sanctum::actingAs(
            $user =  User::factory()->patient()->create()
        );


        $this->postJson('/api/submission', [
            'title' => 'Back pain',
            'symptoms' => fake()->text,
            'other_info' => fake()->text,
            'phone' => fake()->phoneNumber
        ])->assertSuccessful();
    }

    public function testDoctorSubmission()
    {
        Sanctum::actingAs(
            $user = User::factory()->doctor()->create()
        );

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
        Sanctum::actingAs(
            $user = User::factory()->patient()->create()
        );

        $this->postJson('/api/submission', $data)->assertStatus(422);
    }

    public function invalidInformationSubmission()
    {
        return [
            ['no title' => [
              'symptoms' => 'symptoms',
              'other_info' => 'text',
              'phone' => '099123034'
            ]],
            ['no symptoms' => [
                'title' => 'Headache',
                'other_info' => 'Nothing',
                'phone' => '098554738'
            ]],
            ['no data' => [

            ]]
        ];
    }
}
