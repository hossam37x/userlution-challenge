<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin/test user
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'age' => 25,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'age' => 12,
        ]);

        // Create additional random users
        User::factory(10)->create();

        // Create some unverified users
        User::factory(3)->unverified()->create();
    }
}
