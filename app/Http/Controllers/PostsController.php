<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PostsController extends Controller
{
    public function index(User $user = null, Request $request)
    {
        $query = Post::withCount('comments')
            ->with('category', 'user')->latest();

        $selectedCategory = null;
        $categoryId = $request->get('category_id');
        $search = $request->get('search');

        if ($search ) {
            // $query = $query->where('title', 'like', '%' . request('search') . '%');
            $query = $query->search([$search]);
        }

        if (is_numeric($categoryId)) {
            $selectedCategory = Category::findOrFail($categoryId);
            $query = $query->where('category_id', $categoryId);
        }

        if ($user->id != null ) {
            $query = $query->where('user_id', $user->id);
        }

        $posts = $query->paginate(15);

        return view('users.posts.index', [
            'categories' => Category::all(['id','name']),
            'posts' => $posts,
            'selectedCategory' => $selectedCategory,
            'user' => $user,
        ]);

    }

    public function create()
    {
        $categories = Category::all(['id','name']);

        return view('users.posts.create', compact('categories'));

    }

    public function edit(Post $post)
    {
        $categories = Category::all(['id','name']);

        return view('users.posts.edit', compact('categories','post'));

    }

    public function store(StorePostRequest $request)
    {
        $attributes = $request->validated();

        Post::create($attributes);

        return redirect('/posts');
    }

    public function update(Post $post)
    {

        $attributes = Arr::except(\request()->all(),['_token']);

        Post::where('id', $post->id )->update($attributes);
        return redirect()->back();

    }

}
