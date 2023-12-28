<?php

namespace Database\Factories;

use App\Enum\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Task;
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
        $statusDone = fake()->boolean();

        return [
            'creator_id' => User::factory(),
            'parent_id' => fake()->boolean()? null : Task::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->text(),
            'priority'  => fake()->numberBetween(0,5),
            'status' => $statusDone? TaskStatusEnum::DONE: TaskStatusEnum::TODO,
            'completed_at' => $statusDone ?fake()->dateTimeAD():null,
        ];
    }
}
