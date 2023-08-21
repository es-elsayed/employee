<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'permissions-create',
            'permissions-read',
            'permissions-update',
            'permissions-delete',

            'roles-create',
            'roles-read',
            'roles-update',
            'roles-delete',

            'users-create',
            'users-read',
            'users-update',
            'users-delete',

            'departments-create',
            'departments-read',
            'departments-update',
            'departments-delete',

            'employees-create',
            'employees-read',
            'employees-update',
            'employees-delete',

            'tasks-create',
            'tasks-read',
            'tasks-update',
            'tasks-delete',

        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

    }
}
