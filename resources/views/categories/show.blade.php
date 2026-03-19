@extends('layouts.app')
@section('titre', $category->nom)
@section('contenu')

<div class="mb-8">
    <div class="flex items-center gap-3 mb-2">
        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-green-400 rounded-xl flex items-center justify-center text-white text-xl font-bold">
            {{ strtoupper(substr($category->nom, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $category->nom }}</h1>
            <p class="text-gray-500">{{ $posts->total() }} article(s) dans cette catégorie</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    @forelse($posts as $post)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        @if($post->image)
            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}" class="w-32 h-24 object-cover rounded-lg">
        @else
            <div class="w-full h-40 bg-gray-100 rounded-lg mb-4 flex items-center justify-center text-gray-400">
                Pas d'image
            </div>
        @endif
        <h2 class="text-xl font-bold text-gray-800 mb-2">
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
    <p class="text-gray-400 col-span-2 text-center py-12">Aucun article dans cette catégorie.</p>
    @endforelse
</div>

<div class="mt-8">{{ $posts->links() }}</div>

@endsection