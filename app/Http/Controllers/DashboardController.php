<?php

namespace App\Http\Controllers;

use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())
            ->with(['category', 'tags'])
            ->latest()
            ->get();

        $totalLikes = $posts->sum(fn($p) => $p->likes->count());
        $totalComments = $posts->sum(fn($p) => $p->comments->count());

        return view('dashboard.index', compact('posts', 'totalLikes', 'totalComments'));
    }
}