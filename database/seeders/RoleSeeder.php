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
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        // create roles
        $roleAdmin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $rolePlayer = Role::create(['name' => 'player', 'guard_name' => 'api']);

        //Permission::create(['name' => 'list-players']);

        //$roleAdmin->givePermissionTo('list-players');
        //Permission::create(['name' => 'admin.viewAllPlayers'])->assignRole($roleAdmin);
        //Permission::create(['name' => 'admin.deleteAllGamesByPlayer'])->assignRole($roleAdmin);
        //Permission::create(['name' => 'player.viewMyGames'])->assignRole($rolePlayer);

    }
}
