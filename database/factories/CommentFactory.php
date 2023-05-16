<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array

    {
        $userids = User::pluck('id')->toArray();
        $postids = Post::pluck('id')->toArray();
        return [
            'comments' => $this->faker->sentence,
            'user_id' => $this->faker->randomElement($userids),
            'post_id' => $this->faker->randomElement($postids)
        ];
    }
}
