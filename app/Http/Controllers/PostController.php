<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(User $user = null, Request $request)
    {
        $query = Post::with('category', 'user','comment')->latest();
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

        if ($user->id != null) {
            $query = $query->where('user_id', $user->id);
        }

        $posts = $query->paginate(15);

        return view('users.posts.index', [
            'categories' => Category::oldest('name')->get(['id','name']),
            'posts' => $posts,
            'selectedCategory' => $selectedCategory,
            'user' => $user,
        ]);

    }

}
