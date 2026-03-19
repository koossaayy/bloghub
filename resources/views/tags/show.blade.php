@extends('layouts.app')

@section('titre', '#' . $tag->nom)

@section('contenu')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">
        <span class="text-blue-500">#</span>{{ $tag->nom }}
    </h1>
    <p class="text-gray-500">{{ $posts->total() }} article(s) avec ce tag</p>
</div>

<div class="grid grid-cols-2 gap-6">
    @forelse($posts as $post)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        @if($post->image)
            <img src="{{ Storage::url($post->image) }}" class="w-full h-40 object-cover rounded-lg mb-4">
        @else
            <div class="w-full h-40 bg-gray-100 rounded-lg mb-4 flex items-center justify-center text-gray-400">
                Pas d'image
            </div>
        @endif
        <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full uppercase font-semibold">
            {{ $post->category->nom ?? '—' }}
        </span>
        <h2 class="text-xl font-bold text-gray-800 mt-2 mb-2">
            <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
                {{ $post->titre }}
            </a>
        </h2>
        <p class="text-gray-500 text-sm mb-4">{{ Str::limit(strip_tags($post->contenu), 100) }}</p>
        <div class="flex justify-between items-center text-sm text-gray-400">
            <span>{{ $post->user->name }}</span>
            <div class="flex gap-3">
                <span>❤️ {{ $post->likes->count() }}</span>
                <span>💬 {{ $post->comments->count() }}</span>
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-400 col-span-2 text-center py-12">Aucun article avec ce tag.</p>
    @endforelse
</div>

<div class="mt-8">
    {{ $posts->links() }}
</div>

@endsection