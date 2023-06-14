<?php

namespace Tests\Feature\Comments;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    use DatabaseMigrations;
    public function test_user_can_delete_their_own_comments(): void
    {
        // arrange
        $user = User::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
        ]);

        // act
        $this->actingAs($user)
            ->get('comments/'. $comment->id .'/delete');

        // assert
        $this->assertCount(0, Comment::whereId($comment->id)->get());
    }

    public function test_user_cannot_delete_others_users_comments(): void
    {
        $user = User::factory()->create();

        $comment = Comment::factory()->create();

        //act
        $this->actingAs($user)
            ->get('comments/'. $comment->id .'/delete')
            ->assertForbidden();

        // assert
        $this->assertCount(1, Comment::whereId($comment->id)->get());
    }



}
