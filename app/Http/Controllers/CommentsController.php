<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Policies\CommentPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function index(Post $post, Request $request)
    {
    // $request->get('page','1');
        $page = $request->get('page',1);
        session()->put('page', $page);

       $comments = cache()->remember('comments' . $post->id . $request->get('page',1),now()->addHour(), function () use($post)
        {
            return $post->comments()->with('user')->latest()->paginate(2);
        });

        return view('comments.index', [
            'comments' => $comments,
            'post' => $post
        ]);
    }

    public function store(User $user , Post $post, StoreCommentRequest $request)
    {
        $attributes = $request->validated();

        Comment::create($attributes);
        $pageCount = ceil($post->comments()->count()/2);

        for($i = 1 ; $i <= $pageCount ; $i++) {
            cache()->forget('comments' . $post->id . $i );
        }

        return redirect('/posts/'. $post->id . '/comments');
    }
    public function destroy( Post $post ,Comment $comment ,Request $request )
    {
        //both statements are used to call policy
       // $this->authorizeResource(Comment::class, 'comment');
        //$this->authorize('delete', $comment);
        $pageCount = ceil($post->comments()->count()/2);

        $comment->delete();
        for($i = 1 ; $i <= $pageCount ; $i++) {
            cache()->forget('comments' . $post->id . $i );
        }
        return redirect()->back();
    }
}
