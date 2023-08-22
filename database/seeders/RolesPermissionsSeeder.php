<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        foreach ($this->managerPermissions() as $permission) {
            Permission::findByName($permission)->assignRole('manager');
        }

    }

    private function managerPermissions(): array
    {
        return [

            'employees-create',
            'employees-read',
            'employees-update',
            'employees-delete',

            'departments-create',
            'departments-read',
            'departments-update',
            'departments-delete',

            'tasks-create',
            'tasks-read',
            'tasks-update',
            'tasks-delete',

        ];
    }

    // private function employeePermissions(): array
    // {
    //     return [
    //         'tasks-read',
    //         'tasks-update',
    //     ];
    // }
}
