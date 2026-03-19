@extends('layouts.app')

@section('titre', 'Dashboard')

@section('contenu')

<div class="flex gap-8">

    {{-- Sidebar --}}
    <div class="w-56 shrink-0">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Espace Auteur</p>
            <p class="text-sm text-gray-500 mb-6">Gérez vos publications</p>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 font-semibold">
                    📊 Tableau de bord
                </a>
                <a href="{{ route('posts.mes') }}"
    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
    📄 Mes Articles
</a>
                <a href="{{ route('posts.create') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    ➕ Nouvel Article
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    👤 Mon Profil
                </a>
            </nav>
        </div>

        <div class="mt-4">
            <a href="{{ route('posts.create') }}"
                class="w-full block text-center bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90">
                ✏️ Publier maintenant
            </a>
        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="flex-1">

        {{-- Header --}}
        <div class="flex justify-between items-start mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Bienvenue, {{ auth()->user()->name }}</h1>
                <p class="text-gray-500">Voici un aperçu de l'impact de vos écrits cette semaine.</p>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Articles</p>
                <p class="text-3xl font-bold text-gray-800">{{ $posts->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Likes</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalLikes }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Commentaires</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalComments }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Vues</p>
                <p class="text-3xl font-bold text-gray-800">—</p>
            </div>
        </div>

        {{-- Articles récents --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-gray-800">Articles Récents</h2>
                <a href="{{ route('posts.mes') }}" class="text-blue-500 text-sm hover:underline">Voir tout</a>
            </div>

            <table class="w-full">
                <thead>
                    <tr class="text-xs text-gray-400 uppercase border-b border-gray-100">
                        <th class="text-left pb-3">Titre</th>
                        <th class="text-left pb-3">Statut</th>
                        <th class="text-left pb-3">Catégorie</th>
                        <th class="text-left pb-3">Date</th>
                        <th class="text-left pb-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr class="border-b border-gray-50 hover:bg-gray-50">
                        <td class="py-4 text-gray-800 font-medium">{{ Str::limit($post->titre, 40) }}</td>
                        <td class="py-4">
                            @if($post->statut === 'publie')
                                <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full font-semibold uppercase">Publié</span>
                            @elseif($post->statut === 'brouillon')
                                <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full font-semibold uppercase">Brouillon</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full font-semibold uppercase">En attente</span>
                            @endif
                        </td>
                        <td class="py-4 text-gray-500">{{ $post->category->nom ?? '—' }}</td>
                        <td class="py-4 text-gray-400 text-sm">{{ $post->created_at->format('d M Y') }}</td>
                        <td class="py-4">
                            <div class="flex gap-2">
                                <a href="{{ route('posts.edit', $post->id) }}"
                                    class="text-blue-500 hover:text-blue-700">✏️</a>
                                <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700"
                                        onclick="return confirm('Supprimer cet article ?')">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-gray-400 py-8">Aucun article pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection