<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function index(User $user = null, Request $request)
    {
        $query = Post::withCount('comments')
            ->with('category', 'user')
            ->published()
            ->latest();

        $cacheKey = 'posts'. $request->get('page',1);

        $selectedCategory = null;
        $categoryId = $request->get('category_id');
        $search = $request->get('search');

        if ($search) {
             //$query = $query->where('title', 'like', '%' . request('search') . '%');
            $query = $query->search($search);
            $cacheKey = 'posts.' . $search;
        }

        if (is_numeric($categoryId)) {
            $selectedCategory = Category::findOrFail($categoryId);
            $query = $query->where('category_id', $categoryId);
            $cacheKey = 'posts.category.' . $categoryId . $search ?? '' ;
        }

        if ($user->id != null ) {
            $query = $query->where('user_id', $user->id);
            $cacheKey = 'users.posts.' . $categoryId . $search ?? '';
        }
        // cache posts
        /*
        Remember Cache tags are not supported
        when using the file, dynamodb, or database
        cache drivers that's why  we use redis as cache driver to make it work
         */
        $posts = Cache::tags('posts')->remember($cacheKey, now()->addHour(),function () use($query)
        {
            return $query->paginate(5);
        });

        return view('users.posts.index', [
            'categories' => Category::all(),
            'posts' => $posts,
            'selectedCategory' => $selectedCategory,
            'user' => $user,
        ]);
    }

    public function create()
    {
        $post = new Category();
        $categories = $post->all();

        return view('users.posts.create', compact('categories'));
    }

    public function edit(Post $post)
    {
        $categories = new Category();
        $categories = $categories->all();

        return view('users.posts.edit', compact('categories','post'));
    }

    public function store(StorePostRequest $request)
    {
       return $this->save($request->validated(), new Post());
    }

    public function update(Post $post, StorePostRequest $request)
    {
        return $this->save($request->validated(), $post);
    }

    public function delete(Post $post)
    {
        $post->delete();
        Cache::tags('posts')->flush();

        return redirect()->back();
    }

    private function  save(array $attributes, Post $post)
    {
        // condition to check the user if user edit the post
        // and save as draft
        if ($attributes['submit'] === 'Save As Draft') {
            $attributes['published_at'] = null;
        } else {
            $attributes['published_at'] = now();
        }

        //fill works for both update and create
        $post->fill($attributes)->save();
        //clear cache
        Cache::tags('posts')->flush();
        return $attributes['submit'] === 'Save As Draft'
            ? redirect('/users/drafts')
            : redirect('/posts');
    }
}
