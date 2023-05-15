<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userids = User::pluck('id')->toArray();
        $categoryIds = Category::pluck('id')->toArray();
        return [
            'category_id' => $this->faker->randomElement($categoryIds),
            'user_id' => $this->faker->randomElement($userids),
            'title' => $this->faker->sentence,
            'excerpt' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'slug' => $this->faker->slug,
            'published_at' => now()
        ];
    }
}
