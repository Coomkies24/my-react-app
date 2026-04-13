<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create an Admin User (for testing policy/middleware rules)
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@library.com',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        // 2. Create a Regular Member User
        User::factory()->create([
            'name' => 'Regular Member',
            'email' => 'member@library.com',
            'role' => 'member',
            'password' => Hash::make('password'),
        ]);

        // 3. Call your existing library seeder
        $this->call(LibrarySeeder::class);
    }
}
