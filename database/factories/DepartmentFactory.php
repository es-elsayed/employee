<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class DepartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'description' => fake()->text(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Department $department) {
            Employee::factory()
                ->count(3) // Create 3 child categories for each parent
                ->create(['department_id' => $department->id]);
        });
    }
}
