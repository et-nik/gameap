<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Gameap\Models\User;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'user']);

        // User permissions
        $roleUser->givePermissionTo(Permission::create(['name' => 'start game server']));
        $roleUser->givePermissionTo(Permission::create(['name' => 'stop game server']));
        $roleUser->givePermissionTo(Permission::create(['name' => 'restart  server']));
        $roleUser->givePermissionTo(Permission::create(['name' => 'update game server']));

        // Admin permissions
        $roleAdmin->givePermissionTo($roleUser->permissions);

        $roleAdmin->givePermissionTo(Permission::create(['name' => 'admin roles & permissions']));

        $roleAdmin->givePermissionTo(Permission::create(['name' => 'add dedicated server']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'edit dedicated server']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'delete dedicated server']));

        $roleAdmin->givePermissionTo(Permission::create(['name' => 'add game server']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'edit game server']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'delete game server']));

        $roleAdmin->givePermissionTo(Permission::create(['name' => 'add game']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'edit game']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'delete game']));

        $roleAdmin->givePermissionTo(Permission::create(['name' => 'add game mod']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'edit game mod']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'delete game mod']));

        $roleAdmin->givePermissionTo(Permission::create(['name' => 'gdaemon task view']));

        $roleAdmin->givePermissionTo(Permission::create(['name' => 'add user']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'edit user']));
        $roleAdmin->givePermissionTo(Permission::create(['name' => 'delete user']));

        $admin = User::Find(1);
        $admin->assignRole('admin');
    }
}
