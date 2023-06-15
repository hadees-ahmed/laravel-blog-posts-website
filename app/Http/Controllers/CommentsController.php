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
            return $post->comments()->withTrashed()->with('user')->latest()->paginate(2);
        });

        return view('comments.index', [
            'comments' => $comments,
            'post' => $post
        ]);
    }

    public function store(User $user, Post $post, StoreCommentRequest $request)
    {
        if (auth()->user()->is_banned){
            session()->flash('ban','You cannot perform this action because you are banned');
            return redirect()->back();
        }

        $attributes = $request->validated();

        Comment::create($attributes);
        Cache::tags('comments')->flush();
        Cache::tags('posts')->flush();
        return redirect('/posts/'. $post->id . '/comments');
    }
    public function destroy(Comment $comment)
    {
        /* both statements are used to call policy */
       //$this->authorizeResource(Comment::class, 'comment');
        //$this->authorize('delete', $comment);

        $comment->delete();

        Cache::tags('comments')->flush();
        Cache::tags('posts')->flush();
        return redirect()->back();
    }
    public function restore(Comment $comment)
    {
        $comment->restore();
        Cache::tags('comments')->flush();
        Cache::tags('posts')->flush();
        return back();
    }
}
