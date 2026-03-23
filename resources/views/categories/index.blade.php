@extends('layouts.app')
@section('titre', 'Catégories')
@section('contenu')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ __('Toutes les Catégories') }}</h1>
    <p class="text-gray-500">{{ __('Explorez les articles par thématique') }}</p>
</div>

<div class="grid grid-cols-3 gap-6">
    @forelse($categories as $cat)
    <a href="{{ route('categories.show', $cat->slug) }}"
        class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-green-400 rounded-xl flex items-center justify-center text-white text-xl font-bold mb-4">
            {{ strtoupper(substr($cat->nom, 0, 1)) }}
        </div>
        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $cat->nom }}</h2>
        <p class="text-gray-500 text-sm mb-4">{{ $cat->description ?? 'Aucune description.' }}</p>
        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full font-semibold">
            {{ $cat->posts_count }} {{ __('article(s)') }}
        </span>
    </a>
    @empty
    <p class="text-gray-400 col-span-3 text-center py-12">{{ __('Aucune catégorie disponible.') }}</p>
    @endforelse
</div>

@endsection