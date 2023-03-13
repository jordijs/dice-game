<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create(['name' => 'admin']);
        $player = Role::create(['name' => 'player']);

        Permission::create(['name' => 'admin.viewAllPlayers'])->assignRole($admin);
        Permission::create(['name' => 'admin.deleteAllGamesByPlayer'])->assignRole($admin);
        Permission::create(['name' => 'player.viewMyGames'])->assignRole($player);
    }
}
