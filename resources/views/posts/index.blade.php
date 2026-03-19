@extends('layouts.app')

@section('titre', 'Accueil')

@section('contenu')

{{-- Hero --}}
<div class="bg-gray-100 rounded-2xl p-12 text-center mb-10">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">
        L'excellence du <span class="italic text-blue-500">journalisme digital</span> à portée de clic.
    </h1>
    <p class="text-gray-500 mb-6">Découvrez des perspectives uniques et les dernières tendances.</p>
    <form method="GET" action="{{ route('posts.index') }}" class="flex justify-center gap-2">
        <input type="text" name="search" placeholder="Rechercher un article..."
            value="{{ request('search') }}"
            class="w-96 px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-6 py-3 rounded-lg">
            Chercher
        </button>
    </form>
</div>

<div class="flex gap-8">

    {{-- Articles --}}
    <div class="flex-1">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dernières Publications</h2>

        @forelse($posts as $post)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6 flex gap-4">
            @if($post->image)
                <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}" class="w-32 h-24 object-cover rounded-lg">
            @else
                <div class="w-32 h-24 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                    No image
                </div>
            @endif
            <div class="flex-1">
                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full uppercase font-semibold">
                    {{ $post->category->nom ?? 'Sans catégorie' }}
                </span>
                <h3 class="text-xl font-bold text-gray-800 mt-2 mb-1">
                    <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
                        {{ $post->titre }}
                    </a>
                </h3>
                <p class="text-gray-500 text-sm mb-3">
                    {{ Str::limit(strip_tags($post->contenu), 120) }}
                </p>
                <div class="flex items-center justify-between text-sm text-gray-400">
                    <span>{{ $post->user->name }} • {{ $post->created_at->diffForHumans() }}</span>
                    <div class="flex gap-4">
                        <span>❤️ {{ $post->likes->count() }}</span>
                        <span>💬 {{ $post->comments->count() }}</span>
                        <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-500 hover:underline">
                            Lire →
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <p class="text-gray-500 text-center py-12">Aucun article disponible pour le moment.</p>
        @endforelse

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="w-72 shrink-0">

        {{-- Catégories --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Catégories Populaires</h3>
            @foreach($categories as $cat)
            <a href="{{ route('categories.show', $cat->slug) }}"
                class="flex justify-between items-center py-2 border-b border-gray-100 text-gray-600 hover:text-blue-600">
                <span>{{ $cat->nom }}</span>
                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">{{ $cat->posts_count }}</span>
            </a>
            @endforeach
        </div>

        {{-- Tags --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">Tags Tendances</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                <a href="{{ route('tags.show', $tag->slug) }}"
                    class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full hover:bg-blue-100 hover:text-blue-600">
                    #{{ $tag->nom }}
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>

@endsection