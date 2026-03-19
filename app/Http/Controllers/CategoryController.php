<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('posts')->get();
        return view('categories.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()
            ->with(['user', 'tags'])
            ->where('statut', 'publie')
            ->paginate(9);

        return view('categories.show', compact('category', 'posts'));
    }
}