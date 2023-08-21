<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'completed_at' => fake()->boolean ? fake()->date : null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Task $task) {
            $task->employee_id = Employee::inRandomOrder()->first()->id;
            $task->save();
        });
    }
}
