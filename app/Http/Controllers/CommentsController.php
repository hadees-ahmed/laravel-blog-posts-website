<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function create(User $user ,Post $post){
        Comment::create([
            'comments' => \request('comment'),
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        return redirect('/posts');
    }
}
