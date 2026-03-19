<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category', 'tags'])
            ->where('statut', 'publie')
            ->latest()
            ->paginate(9);

        $categories = Category::withCount('posts')->get();
        $tags = Tag::withCount('posts')->get();

        return view('posts.index', compact('posts', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $post = Post::with(['user', 'category', 'tags', 'comments', 'likes'])
            ->where('slug', $slug)
            ->where('statut', 'publie')
            ->firstOrFail();

        return view('posts.show', compact('post'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('posts.create', compact('categories', 'tags'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'       => 'required|max:255',
            'contenu'     => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post = Post::create([
            'user_id'     => auth()->id(),
            'category_id' => $request->category_id,
            'titre'       => $request->titre,
            'slug'        => Str::slug($request->titre) . '-' . uniqid(),
            'contenu'     => $request->contenu,
            'statut'      => $request->statut ?? 'en_attente',
            'image'       => $request->file('image')
                                ? $request->file('image')->store('posts', 'public')
                                : null,
        ]);

        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Article soumis pour modération !');
    }

    public function edit($id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $categories = Category::all();
        $tags = Tag::all();

        return view('posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $request->validate([
            'titre'       => 'required|max:255',
            'contenu'     => 'required',
            'category_id' => 'required|exists:categories,id',
        ]);

        $post->update([
            'titre'       => $request->titre,
            'category_id' => $request->category_id,
            'contenu'     => $request->contenu,
            'statut'      => 'en_attente',
        ]);

        if ($request->tags) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('dashboard')
            ->with('success', 'Article mis à jour !');
    }

    public function destroy($id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $post->delete();

        return redirect()->route('dashboard')
            ->with('success', 'Article supprimé !');
    }

    public function like($id)
    {
        $like = Like::where('post_id', $id)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            $like->delete();
        } else {
            Like::create([
                'post_id' => $id,
                'user_id' => auth()->id(),
            ]);
        }

        return back();
    }

    public function mesArticles()
    {
        $posts = Post::where('user_id', auth()->id())
            ->with(['category', 'tags'])
            ->latest()
            ->paginate(10);

        return view('posts.mes-articles', compact('posts'));
    }
}