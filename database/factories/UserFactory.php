<?php

namespace Database\Factories;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    private $type;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }



    public function patient()
    {
        $role = 'Patient';
        return $this->afterCreating(function (User $user) use ($role) {
                    $role = Role::firstOrCreate([
                        'name' => $role,
                        'guard_name' => 'sanctum'
                    ]);
                $user->assignRole($role);
        });
    }

    public function doctor()
    {
        $role = 'Doctor';
        return $this->afterCreating(function (User $user) use ($role) {
            $role = Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'sanctum'
            ]);
            $user->assignRole($role);
        });
    }

}
