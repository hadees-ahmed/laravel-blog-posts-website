<?php

namespace App\Policies;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
   use BeforeTrait;

    /**
     * Create a new policy instance.
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $comment->user?->id === $user->id
            || $comment->post?->user_id === $user->id;
    }
    public function undo(User $user, Comment $comment)
    {
        return $user->id == $comment->user_id;
    }
}
