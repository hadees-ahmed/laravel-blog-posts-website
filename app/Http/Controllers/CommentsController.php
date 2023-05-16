<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class CommentsController extends Controller
{
    public function index(Post $post)
    {
        $post->load('comments', 'user', 'category');

        return view('comments.index', [
            'post' => $post
        ]);
    }

    public function create(User $user ,Post $post, Request $request){
        $request->validate([
            'comment'=>'max:255|min:1'
        ]);
        Comment::create([
            'comments' => $request->get('comment'),
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        return redirect('/posts/'. $post->id . '/comments');
    }
}
