@extends('layouts.app')

@section('titre', 'Dashboard')

@section('contenu')

<div class="flex gap-8">

    {{-- Sidebar --}}
    <div class="w-64 shrink-0">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 text-center mb-4">
            {{-- Avatar --}}
            <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto mb-3">
                @if(auth()->user()->avatar)
                    <img src="{{ Storage::url(auth()->user()->avatar) }}" class="w-20 h-20 rounded-full object-cover">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
            <p class="font-bold text-gray-800">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-400 uppercase font-semibold mt-1">Espace Auteur</p>
            <p class="text-sm text-gray-500">Gérez vos publications</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <nav class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 font-semibold">
                    <span class="text-lg">📊</span> Tableau de bord
                </a>
                <a href="{{ route('posts.mes') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    <span class="text-lg">📄</span> Mes Articles
                </a>
                <a href="{{ route('posts.create') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    <span class="text-lg">➕</span> Nouvel Article
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    <span class="text-lg">👤</span> Mon Profil
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
                <h1 class="text-3xl font-bold text-gray-800">Bienvenue, {{ explode(' ', auth()->user()->name)[0] }}</h1>
                <p class="text-gray-500">Voici un aperçu de l'impact de vos écrits cette semaine.</p>
            </div>
            <div class="bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm text-gray-600 flex items-center gap-2">
                📅 {{ now()->subDays(7)->format('d M') }} — {{ now()->format('d M Y') }}
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">📄</div>
                    <span class="text-green-500 text-sm font-semibold">+12%</span>
                </div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Articles</p>
                <p class="text-3xl font-bold text-gray-800">{{ $posts->count() }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-3">
                    <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">❤️</div>
                    <span class="text-green-500 text-sm font-semibold">+5%</span>
                </div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Likes</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalLikes }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex justify-between items-start mb-3">
                    <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-2xl">💬</div>
                    <span class="text-red-500 text-sm font-semibold">-2%</span>
                </div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Total Commentaires</p>
                <p class="text-3xl font-bold text-gray-800">{{ $totalComments }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 border-l-4 border-l-blue-500">
                <div class="flex justify-between items-start mb-3">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">👁️</div>
                    <span class="text-green-500 text-sm font-semibold">+18%</span>
                </div>
                <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Vues</p>
                <p class="text-3xl font-bold text-gray-800">—</p>
            </div>
        </div>

        <div class="flex gap-6">

            {{-- Articles récents --}}
            <div class="flex-1">
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
                                <td class="py-4 text-gray-800 font-medium">{{ Str::limit($post->titre, 30) }}</td>
                                <td class="py-4">
                                    @if($post->statut === 'publie')
                                        <span class="bg-green-100 text-green-600 text-xs px-3 py-1 rounded-full font-semibold uppercase">Publié</span>
                                    @elseif($post->statut === 'brouillon')
                                        <span class="bg-gray-100 text-gray-600 text-xs px-3 py-1 rounded-full font-semibold uppercase">Brouillon</span>
                                    @else
                                        <span class="bg-yellow-100 text-yellow-600 text-xs px-3 py-1 rounded-full font-semibold uppercase">En attente</span>
                                    @endif
                                </td>
                                <td class="py-4 text-gray-500 text-sm">{{ $post->category->nom ?? '—' }}</td>
                                <td class="py-4 text-gray-400 text-sm">{{ $post->created_at->format('d M Y') }}</td>
                                <td class="py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="text-blue-500 hover:text-blue-700">✏️</a>
                                        <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700"
                                                onclick="return confirm('Supprimer ?')">🗑️</button>
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

            {{-- Sidebar droite --}}
            <div class="w-64 shrink-0">

                {{-- Brouillon rapide --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="font-bold text-gray-800 mb-4">Brouillon rapide</h3>
                    <form method="POST" action="{{ route('posts.store') }}">
                        @csrf
                        <input type="hidden" name="statut" value="brouillon">
                        <input type="hidden" name="category_id" value="{{ App\Models\Category::first()->id ?? 1 }}">
                        <input type="text" name="titre" placeholder="Titre de l'idée..."
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 mb-3">
                        <textarea name="contenu" rows="3" placeholder="Qu'avez-vous en tête ?"
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 mb-3 resize-none"></textarea>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
                            Enregistrer le brouillon
                        </button>
                    </form>
                </div>

                {{-- Catégories tendances --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <h3 class="font-bold text-gray-800 mb-4">Catégories Tendances</h3>
                    @foreach(App\Models\Category::withCount(['posts' => function($q){ $q->where('statut','publie'); }])->orderByDesc('posts_count')->take(3)->get() as $index => $cat)
                    <div class="flex justify-between items-center py-2">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 rounded-full {{ $index === 0 ? 'bg-blue-500' : ($index === 1 ? 'bg-green-500' : 'bg-gray-400') }}"></div>
                            <span class="text-gray-700 text-sm">{{ $cat->nom }}</span>
                        </div>
                        <span class="text-gray-400 text-sm">{{ $cat->posts_count > 0 ? round(($cat->posts_count / max(App\Models\Post::where('statut','publie')->count(), 1)) * 100) : 0 }}%</span>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>

@endsection