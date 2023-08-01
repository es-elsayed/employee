<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = User::factory()->create([
            'name' => "Islam Abdu",
            'email' => 'islam3bdu@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $admin->assignRole('super-admin');

    }
}
