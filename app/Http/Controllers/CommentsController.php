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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CommentsController extends Controller
{
    public function index(Post $post, Request $request)
    {

        /*
        Remember Cache tags are not supported
        when using the file, dynamodb, or database
        cache drivers that's why  we use redis as cache driver to make it work
         */
       $comments = Cache::tags('comments')->remember('comments' . $post->id . $request->get('page',1),now()->addHour(), function () use($post)
        {
            return $post->comments()->with('user')->latest()->paginate(2);
        });

        return view('comments.index', [
            'comments' => $comments,
            'post' => $post
        ]);
    }

    public function store(User $user, Post $post, StoreCommentRequest $request)
    {
        $attributes = $request->validated();

        Comment::create($attributes);
        Cache::tags('comments')->flush();

        return redirect('/posts/'. $post->id . '/comments');
    }
    public function destroy( Post $post ,Comment $comment ,Request $request )
    {
        /* both statements are used to call policy */
       // $this->authorizeResource(Comment::class, 'comment');
        //$this->authorize('delete', $comment);

        $comment->delete();

        Cache::tags('comments')->flush();

        return redirect()->back();
    }
    public function restore(Comment $comment)
    {
        $comment->restore();
        return back();
    }

}
