<?php

namespace Tests\Feature;

use App\Models\Submission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AssignSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function testAssignSubmissionSuccess()
    {
        Sanctum::actingAs(
            $doctor = User::factory()->doctor()->create()
        );

        Submission::factory(10)->create();
        $sub = Submission::first();
        $this->putJson('/api/submissions/' . $sub->id)->assertSuccessful();
    }

    public function testPatientAssignSubmission()
    {
        Sanctum::actingAs(
            User::factory()->patient()->create()
        );

        Submission::factory(10)->create();
        $sub = Submission::first();

        $this->putJson('/api/submissions/' . $sub->id)->assertStatus(403);
    }

    public function testAssignedDoctorSubmission()
    {
        $doctor = User::factory()->doctor()->create();

        $sub = Submission::factory()->create([
            'doctor_id' => $doctor->id
        ]);

        Sanctum::actingAs(
            $doctor2 = User::factory()->doctor()->create()
        );

        $this->putJson('/api/submissions/' . $sub->id)->assertStatus(403);
    }
}
