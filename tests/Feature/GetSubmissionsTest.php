<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GetSubmissionsTest extends TestCase
{


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