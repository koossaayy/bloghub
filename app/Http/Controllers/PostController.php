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
    $search = request('search');
    $sort = request('sort', 'recent');
    $category = request('category');

    $query = Post::with(['user', 'category', 'tags', 'likes', 'comments'])
        ->where('statut', 'publie');

    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('titre', 'ilike', "%{$search}%")
              ->orWhere('contenu', 'ilike', "%{$search}%")
              ->orWhereHas('user', function($q) use ($search) {
                  $q->where('name', 'ilike', "%{$search}%");
              })
              ->orWhereHas('category', function($q) use ($search) {
                  $q->where('nom', 'ilike', "%{$search}%");
              });
        });
    }

    if ($category) {
        $query->whereHas('category', function($q) use ($category) {
            $q->where('slug', $category);
        });
    }

    if ($sort === 'likes') {
        $query->withCount('likes')->orderByDesc('likes_count');
    } elseif ($sort === 'comments') {
        $query->withCount('comments')->orderByDesc('comments_count');
    } else {
        $query->latest();
    }

    $posts = $query->paginate(9);
    $categories = Category::withCount('posts')->get();
    $tags = Tag::withCount('posts')->get();

    return view('posts.articles', compact('posts', 'categories', 'tags', 'search', 'sort'));
}

    public function accueil()
{
    $posts = Post::with(['user', 'category', 'tags', 'likes', 'comments'])
        ->where('statut', 'publie')
        ->latest()
        ->paginate(5);

    $categories = Category::withCount('posts')->get();
    $tags = Tag::withCount('posts')->get();
    $sort = 'recent';
    $search = null;

    return view('posts.index', compact('posts', 'categories', 'tags', 'sort', 'search'));
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

    // Admin publie directement, auteur passe par modération
    $statut = auth()->user()->isAdmin() ? 'publie' : 'en_attente';

    $post = Post::create([
        'user_id'     => auth()->id(),
        'category_id' => $request->category_id,
        'titre'       => $request->titre,
        'slug'        => Str::slug($request->titre) . '-' . uniqid(),
        'contenu'     => $request->contenu,
        'statut'      => $statut,
        'image'       => $request->file('image')
                            ? $request->file('image')->store('posts', 'public')
                            : null,
    ]);

    if ($request->tags) {
        $post->tags()->sync($request->tags);
    }

    if (auth()->user()->isAdmin()) {
        return redirect()->route('dashboard')
            ->with('success', __('Article publié avec succès !'));
    }

    return redirect()->route('dashboard')
        ->with('success', __('Article soumis pour modération !'));
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

    $statut = auth()->user()->isAdmin() ? 'publie' : 'en_attente';

    $post->update([
        'titre'       => $request->titre,
        'category_id' => $request->category_id,
        'contenu'     => $request->contenu,
        'statut'      => $statut,
    ]);

    if ($request->tags) {
        $post->tags()->sync($request->tags);
    }

    return redirect()->route('dashboard')
        ->with('success', __('Article mis à jour !'));
}

    public function destroy($id)
    {
        $post = Post::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $post->delete();

        return redirect()->route('dashboard')
            ->with('success', __('Article supprimé !'));
    }

    public function like($id)
{
    if (!auth()->check()) {
        return response()->json(['error' => 'Non connecté'], 401);
    }

    $like = Like::where('post_id', $id)
        ->where('user_id', auth()->id())
        ->first();

    if ($like) {
        $like->delete();
        $liked = false;
    } else {
        Like::create([
            'post_id' => $id,
            'user_id' => auth()->id(),
        ]);
        $liked = true;
    }

    $count = Like::where('post_id', $id)->count();

    return response()->json([
        'liked' => $liked,
        'count' => $count
    ]);
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