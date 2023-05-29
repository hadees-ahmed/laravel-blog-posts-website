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

        // looping through posts to set manual relationships for user & category
        // we are doing this so we dont have to make additional queries

        // because we have paginated items we cant use a simple loop & have to use this
        $posts = tap($posts, function($paginatedInstance) use ($categories) {
            return $paginatedInstance->getCollection()->transform(function ($post) use($categories) {
                // use setRelation func to attach user relationship
                $post->setRelation('user', auth()->user());

                // use setRelation func to attach category relationship
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
