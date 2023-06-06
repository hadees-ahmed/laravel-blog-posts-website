<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Policies\CommentPolicy;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CommentsController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()
            ->withTrashed()->with('user')->latest()->paginate(5);

        return view('comments.index', [
            'comments' => $comments,
            'post' => $post
        ]);
    }

    public function store(User $user, Post $post, StoreCommentRequest $request)
    {
        $attributes = $request->validated();

        Comment::create($attributes);

        return redirect('/posts/'. $post->id . '/comments');
    }
    public function destroy(Comment $comment)
    {
        //both statements are used to call policy
       // $this->authorizeResource(Comment::class, 'comment');
        //$this->authorize('delete', $comment);
        session()->put('comment', $comment);

        $comment->delete();
        return redirect()->back();
    }
    public function restore(Comment $comment)
    {
        $comment->restore();
        return back();
    }

}
