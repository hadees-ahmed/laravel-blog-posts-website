<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        \App\Models\User::factory(1)->create([
            'name' => 'Hadees Ahmed',
            'email' => 'hadeesahmed@yahoo.com',
            'password' => 'hadees'
        ]);
        //
        $users = User::factory(10)->create();


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $categories = Category::factory(30)->create();
        $posts = collect();

        for ($i = 0; $i < 200; $i++) {
            $post = Post::factory()
                ->create([
                    'category_id' => $categories->random()->id,
                    'user_id' => $users->random()->id,
                ]);
            $posts->push($post);
        }

        for ($i = 0; $i < 500; $i++) {
            Comment::factory()->create([
                'user_id' => $users->random()->id,
                'post_id' => $posts->random()->id,
            ]);
        }
    }
}
