<?php

namespace Tests\Feature\Comments;

use App\Models\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use App\Models\Comment;
use App\Models\User;

class StoreTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_create_comment(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $attributes = [
            'comments' => 'hello',
            'user_id' => $user->id,
            'post_id' => $post->id
        ];


        $this->actingAs($user)->post('users/' . $user->id . '/' . $post->id . '/comments', $attributes);

        $this->assertDatabaseHas('comments', [
            'comments' => 'hello',
        ]);
        $this->assertNull(Cache::tags('comments')->get('comments')); // Assuming the 'comments' cache tag is cleared
        $this->assertNull(Cache::tags('posts')->get('posts')); // Assuming the 'posts' cache tag is cleared
    }

        public function test_user_can_associate_comment_to_his_name_only()
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $attributes = [
            'comments' => 'hello',
            'post_id' => $post->id
        ];

        $this->actingAs($user)
            ->post('users/' . $user->id . '/' . $post->id . '/comments', $attributes);

        $this->assertDatabaseMissing('comments', [
            'comments' => 'hello',
        ]);
    }
}
