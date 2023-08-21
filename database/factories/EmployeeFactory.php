<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = fake()->email();
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => $email,
            'password' => Hash::make($email),
            'salary' => fake()->numberBetween(1111, 9999),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Employee $employee) {
            if ($employee->manager_id == null) {
                Employee::factory()
                    ->count(3) // Create 3 child categories for each parent
                    ->create(['manager_id' => $employee->id]);}
        });
    }
}
