<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;


class PostsDraftsController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->user()->id)
            ->drafts()
            ->latest()
            ->paginate();

        $categories =  Category::all(['id','name']);

        //
        $posts = tap($posts, function($paginatedInstance) use ($categories) {
            return $paginatedInstance->getCollection()->transform(function ($post) use($categories) {
                //
                $post->setRelation('user', auth()->user());

                //
                $post->setRelation('category', $categories->where('id', $post->category_id)->first());

                return $post;
            });
        });

        return view('users.posts.index',[
            'categories' => $categories,
            'posts' => $posts,
            'user' => auth()->user(),
        ]);
    }
}
