@extends('layouts.app')

@section('titre', 'Accueil')

@section('contenu')

{{-- Hero --}}
<div class="bg-gray-100 rounded-2xl p-16 text-center mb-12">
    <h1 class="text-5xl font-bold text-gray-800 mb-4 leading-tight">
        L'excellence du <span class="italic text-blue-500">journalisme digital</span> à portée de clic.
    </h1>
    <p class="text-gray-500 mb-8 text-lg max-w-xl mx-auto">
        Découvrez des perspectives uniques, des analyses approfondies et les dernières tendances du monde technologique et culturel.
    </p>
    <form method="GET" action="{{ route('posts.index') }}" class="flex justify-center gap-2">
        <input type="text" name="search" placeholder="Rechercher un sujet, un auteur ou un article..."
            value="{{ request('search') }}"
            class="w-96 px-5 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white">
        <button class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90">
            Chercher
        </button>
    </form>
</div>

<div class="flex gap-8">

    {{-- Articles --}}
    <div class="flex-1">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Dernières Publications</h2>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('posts.index') }}" class="text-blue-600 font-semibold border-b-2 border-blue-600 pb-1">Plus récents</a>
                <a href="{{ route('posts.index', ['sort' => 'likes']) }}" class="text-gray-500 hover:text-blue-600">Populaires</a>
                <a href="{{ route('posts.index', ['sort' => 'comments']) }}" class="text-gray-500 hover:text-blue-600">Tendances</a>
            </div>
        </div>

        {{-- Article featured (premier) --}}
        @if($posts->count() > 0)
        @php $featured = $posts->first(); @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden hover:shadow-md transition-shadow">
            <div class="flex gap-0">
                <div class="w-64 shrink-0">
                    @if($featured->image)
                        <img src="{{ Str::startsWith($featured->image, 'http') ? $featured->image : Storage::url($featured->image) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 min-h-48">
                            📄
                        </div>
                    @endif
                </div>
                <div class="p-6 flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full uppercase font-semibold">
                            {{ strtoupper($featured->category->nom ?? 'Sans catégorie') }}
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2 hover:text-blue-600">
                        <a href="{{ route('posts.show', $featured->slug) }}">{{ $featured->titre }}</a>
                    </h3>
                    <p class="text-gray-500 mb-4">{{ Str::limit(strip_tags($featured->contenu), 150) }}</p>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($featured->user->name, 0, 1)) }}
                            </div>
                            <span class="text-sm text-gray-600 font-medium">{{ $featured->user->name }}</span>
                            <span class="text-gray-400 text-sm">• {{ $featured->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-gray-400 text-sm flex items-center gap-1">❤️ {{ $featured->likes->count() }}</span>
                            <span class="text-gray-400 text-sm flex items-center gap-1">💬 {{ $featured->comments->count() }}</span>
                            <a href="{{ route('posts.show', $featured->slug) }}"
                                class="text-blue-500 font-semibold text-sm hover:underline">
                                Continuer la lecture →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Autres articles --}}
        <div class="grid grid-cols-2 gap-6">
            @foreach($posts->skip(1) as $post)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                @if($post->image)
                    <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}"
                        class="w-full h-44 object-cover">
                @else
                    <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-gray-400 text-3xl">📄</div>
                @endif
                <div class="p-5">
                    <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full uppercase font-semibold">
                        {{ $post->category->nom ?? '—' }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 mt-2 mb-2 hover:text-blue-600">
                        <a href="{{ route('posts.show', $post->slug) }}">{{ Str::limit($post->titre, 60) }}</a>
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">{{ Str::limit(strip_tags($post->contenu), 80) }}</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                            <span class="text-xs text-gray-500">{{ $post->user->name }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ ceil(str_word_count(strip_tags($post->contenu)) / 200) }} MIN LECTURE</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="w-72 shrink-0">

        {{-- Catégories Populaires --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Catégories Populaires</h3>
            @foreach($categories as $cat)
            <a href="{{ route('categories.show', $cat->slug) }}"
                class="flex justify-between items-center py-2 border-b border-gray-50 text-gray-600 hover:text-blue-600">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-sm">{{ $cat->nom }}</span>
                </div>
                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full font-semibold">{{ $cat->posts_count }}</span>
            </a>
            @endforeach
        </div>

        {{-- Tags Tendances --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Tags Tendances</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                <a href="{{ route('tags.show', $tag->slug) }}"
                    class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full hover:bg-blue-100 hover:text-blue-600 transition-colors">
                    #{{ $tag->nom }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Auteurs Vedettes --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Auteurs Vedettes</h3>
            @foreach(\App\Models\User::withCount('posts')->where('role', 'auteur')->orWhere('role', 'admin')->orderByDesc('posts_count')->take(3)->get() as $auteur)
            <div class="flex items-center gap-3 py-2 border-b border-gray-50">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">