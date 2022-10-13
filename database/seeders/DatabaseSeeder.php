<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Submission;
use App\Models\User;
use Illuminate\Database\Seeder;
use PHP_CodeSniffer\Reports\Summary;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Submission::factory(10)->create();
        $this->call([PermissionSeeder::class]);
         //User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
