<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->roles() as $key => $value) {
            Role::create([
                'guard_name' => $key,
                'name' => $value,
            ]);
        }
    }

    private function roles(): array
    {

        return [
            'super_admin' => 'Super Admin',
            'user' => 'User',
            'client' => 'Client',
            'content_writer' => 'Content Writer',
        ];
    }
}
