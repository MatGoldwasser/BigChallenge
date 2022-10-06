<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetSubmissionsTest extends TestCase
{

    use RefreshDatabase;

    public function testGetSubmissionsPatientSuccess()
    {
        Sanctum::actingAs(
            $user = User::factory()->patient()->create()
        );

        $this->getJson('/api/submissions')->assertSuccessful();
    }

    public function testGetSubmissionsDoctorSuccess()
    {
        Sanctum::actingAs(
            $user = User::factory()->doctor()->create()
        );

        $this->getJson('/api/submissions')->assertSuccessful();
    }

    public function testNotLoggedIn()
    {
        $this->getJson('/api/submissions')->assertStatus(401);
    }

}
