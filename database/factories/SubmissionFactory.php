<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Submission>
 */
class SubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'patient_id' => User::factory()->patient()->create(),
            'doctor_id' => null,
            'title' => fake()->text,
            'symptoms' => fake()->text,
            'other_info' => fake()->text,
            'phone' => fake()->phoneNumber,
            'status' => 'inProgress'
        ];
    }
}
