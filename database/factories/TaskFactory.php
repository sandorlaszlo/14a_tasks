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
        $users = User::all();
        return [
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'published_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'user_id' => $users->random()->id,
        ];
    }
}
