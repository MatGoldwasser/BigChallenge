<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class GetSubmissionsTest extends TestCase
{
    use RefreshDatabase;

    public function testGetSubmissionsPatientSuccess()
    {
        Sanctum::actingAs(
            $patient = User::factory()->patient()->create()
        );

        Submission::factory([
            'patient_id' => $patient
        ])->create();

        Submission::factory(5)->create();


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

    public function testSubmissionAlreadyAcceptedByAnotherDoctor()
    {
        Sanctum::actingAs(
            $doctor = User::factory()->doctor()->create()
        );

        Submission::factory(10)->create();
        Submission::factory([
            'doctor_id' => $doctor
        ])->create();
        Submission::factory([
            'doctor_id' => (User::factory()->doctor()->create())
        ])->create();

        $respuesta = $this->getJson('/api/submissions');

        $respuesta->assertJsonCount(11, 'data');
    }

    public function testPatientWantsToSeeAnotherPatientSubmission()
    {
        Sanctum::actingAs(
            $user = User::factory()->patient()->create()
        );

        Submission::factory(8);

        Submission::factory([
            'patient_id' => $user
        ])->create();

        $respuesta = $this->getJson('/api/submissions');

        $respuesta->assertJsonCount(1, 'data');
    }
}
