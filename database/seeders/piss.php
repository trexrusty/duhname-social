<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class piss extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'view reports']);
        Permission::create(['name' => 'delete reports']);
        Permission::create(['name' => 'ban user']);
        Permission::create(['name' => 'delete post']);
        Permission::create(['name' => 'hide post']);
        Permission::create(['name' => 'delete comment']);
        // update cache to know about the newly created permissions (required if using WithoutModelEvents in seeders)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'admin']);
        $role->givePermissionTo('view reports');
        $role->givePermissionTo('delete reports');
        $role->givePermissionTo('ban user');
        $role->givePermissionTo('delete post');
        $role->givePermissionTo('hide post');
        $role->givePermissionTo('delete comment');

        // or may be done by chaining
        $role = Role::create(['name' => 'moderator'])
            ->givePermissionTo(['view reports', 'delete reports', 'ban user', 'hide post', 'delete comment']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
