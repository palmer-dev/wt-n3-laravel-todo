<?php

namespace Database\Factories;

use App\Models\User;
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
            'name' => fake()->sentence(5),
            'date' => fake()->dateTimeBetween("2024-01-01 00:00:00", "2024-12-31 23:59:59"),
            'comment' => fake()->text(2000),
            'user_id' => User::where("email", "test@example.com")->first()->id
        ];
    }
}
