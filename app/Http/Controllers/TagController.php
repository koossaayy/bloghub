<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagController extends Controller
{
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()
            ->with(['user', 'category'])
            ->where('statut', 'publie')
            ->paginate(9);

        return view('tags.show', compact('tag', 'posts'));
    }
}