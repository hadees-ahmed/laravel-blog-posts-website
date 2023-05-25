<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Policies\CommentPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()->with('user')->latest()->paginate(5);

        return view('comments.index', [
            'comments' => $comments,
            'post' => $post
        ]);
    }

    public function create(User $user ,Post $post, Request $request)
    {
        $request->validate([
            'comment' => 'required|profanity|max:3000|min:1'
        ]);

        Comment::create([
            'comments' => $request->get('comment'),
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        return redirect('/posts/'. $post->id . '/comments');
    }
    public function destroy(Comment $comment)
    {

        //both statements are used to call policy
       // $this->authorizeResource(Comment::class, 'comment');
        //$this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back();
    }
}
