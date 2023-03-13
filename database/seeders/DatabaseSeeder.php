<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::factory()->create([
            'name' => 'Test Admin User',
            'email' => 'test@example.com',
        ])->assignRole('admin');

        User::factory()->create([
            'name' => 'Test Player User',
            'email' => 'player1@example.com',
        ])->assignRole('player');

        User::factory()->create([
            'name' => 'Test 2nd  Player User',
            'email' => 'player2@example.com',
        ])->assignRole('player');
    }
}
