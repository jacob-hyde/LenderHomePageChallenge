<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enum\TaskStatusEnum;
use App\Models\Task;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Task $task) {
            if (mt_rand(0, 3) === 0) {
                $parentTask = Task::where('user_id', $task->user_id)->inRandomOrder()->first();
                if ($parentTask) {
                    $task->parent_id = $parentTask->id;
                    $task->save();
                    $task->parentPivot()->attach($parentTask->id);
                }
            }
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(mt_rand(1, 3), true),
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(TaskStatusEnum::cases()),
            'status_changed_at' => $this->faker->dateTimeBetween('-2 days', 'now'),
            'parent_id' => null,
            'user_id' => null,
        ];
    }
}
