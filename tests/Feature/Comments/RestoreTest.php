<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RestoreTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_restore_their_own_comments()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'deleted_at' => now(),
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->get('comments/'. $comment->id .'/restore');

        $this->assertNull(Comment::find($comment->id)->deleted_at);
        $this->assertNull($comment->fresh()->deleted_at);
        $this->assertDatabaseHas('comments', [
           'id' => $comment->id,
           'deleted_at' => null
        ]);
    }

    public function test_user_cannot_restore_other_users_comments()
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'deleted_at' => now(),
        ]);

        $this->actingAs($user)
            ->get('comments/'. $comment->id .'/restore');

        $this->assertDatabaseHas('comments',[
            'deleted_at' => $comment->deleted_at
        ]);

    }
}
