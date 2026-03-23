<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;

class StatsController extends Controller
{
    public function index()
    {
        $stats = [
            'posts' => Post::count(),
            'categories' => Category::count(),
            'tags' => Tag::count(),
            'comments' => Comment::count(),
            'users' => User::count(),
        ];

        return view('stats', compact('stats'));
    }
}
