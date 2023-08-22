<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::factory()->times(10)->create()->each(function ($user) {
            // Assign a role to each user here
            $user->assignRole('manager'); // Assuming you have a method like assignRole() in your User model to assign roles.
        });

    }
}
