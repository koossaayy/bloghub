@extends('layouts.app')

@section('titre', 'Panneau de Modération')

@section('contenu')

<div class="flex gap-8">

    {{-- Sidebar --}}
    <div class="w-56 shrink-0">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Espace Auteur</p>
            <p class="text-sm text-gray-500 mb-6">Gérez vos publications</p>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    📊 Tableau de bord
                </a>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 font-semibold">
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
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Panneau de Modération</h1>
                <p class="text-gray-500">Supervisez le contenu et la communauté BlogHub</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-gray-600 font-semibold">{{ auth()->user()->name }}</span>
                <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center font-bold text-gray-600">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl border border-gray-100 p-6 flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Articles en attente</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $postEnAttente->count() }}</p>
                </div>
                <span class="text-3xl">✅</span>
            </div>
            <div class="bg-white rounded-xl border border-gray-100 p-6 flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Nouveaux Auteurs</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $users->where('role', 'auteur')->count() }}</p>
                </div>
                <span class="text-3xl">👥</span>
            </div>
            <div class="bg-white rounded-xl border border-red-100 p-6 flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Commentaires signalés</p>
                    <p class="text-3xl font-bold text-gray-800">{{ $commentsSignales->count() }}</p>
                </div>
                <span class="text-3xl">⚠️</span>
            </div>
        </div>

        {{-- Tabs --}}
        <div x-data="{ tab: 'articles' }">

            <div class="flex gap-6 border-b border-gray-200 mb-6">
                <button @click="tab = 'articles'"
                    :class="tab === 'articles' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500'"
                    class="pb-3 font-semibold flex items-center gap-2">
                    Articles en attente
                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded-full">{{ $postEnAttente->count() }}</span>
                </button>
                <button @click="tab = 'comments'"
                    :class="tab === 'comments' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500'"
                    class="pb-3 font-semibold flex items-center gap-2">
                    Commentaires signalés
                    <span class="bg-red-100 text-red-600 text-xs px-2 py-0.5 rounded-full">{{ $commentsSignales->count() }}</span>
                </button>
                <button @click="tab = 'users'"
                    :class="tab === 'users' ? 'border-b-2 border-blue-500 text-blue-600' : 'text-gray-500'"
                    class="pb-3 font-semibold">
                    Gestion utilisateurs
                </button>
            </div>

            {{-- Articles en attente --}}
            <div x-show="tab === 'articles'">
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-xs text-gray-400 uppercase">
                                <th class="text-left px-6 py-4">Article</th>
                                <th class="text-left px-6 py-4">Auteur</th>
                                <th class="text-left px-6 py-4">Date</th>
                                <th class="text-left px-6 py-4">Catégorie</th>
                                <th class="text-left px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postEnAttente as $post)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-800">{{ Str::limit($post->titre, 50) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-xs font-bold">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <span class="text-gray-600">{{ $post->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full uppercase font-semibold">
                                        {{ $post->category->nom ?? '—' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.posts.approuver', $post->id) }}">
                                            @csrf @method('PUT')
                                            <button class="bg-green-100 text-green-600 px-3 py-1 rounded-lg text-sm font-semibold hover:bg-green-200">
                                                Approuver
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.posts.rejeter', $post->id) }}">
                                            @csrf @method('PUT')
                                            <button class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-sm font-semibold hover:bg-red-200">
                                                Rejeter
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-gray-400 py-8">Aucun article en attente.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Commentaires signalés --}}
            <div x-show="tab === 'comments'">
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-xs text-gray-400 uppercase">
                                <th class="text-left px-6 py-4">Commentaire</th>
                                <th class="text-left px-6 py-4">Auteur</th>
                                <th class="text-left px-6 py-4">Article</th>
                                <th class="text-left px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($commentsSignales as $comment)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-600">{{ Str::limit($comment->contenu, 60) }}</td>
                                <td class="px-6 py-4 text-gray-600">{{ $comment->nom }}</td>
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ Str::limit($comment->post->titre ?? '—', 30) }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.comments.approuver', $comment->id) }}">
                                            @csrf @method('PUT')
                                            <button class="bg-green-100 text-green-600 px-3 py-1 rounded-lg text-sm font-semibold hover:bg-green-200">
                                                Approuver
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.comments.supprimer', $comment->id) }}">
                                            @csrf @method('DELETE')
                                            <button class="bg-red-100 text-red-600 px-3 py-1 rounded-lg text-sm font-semibold hover:bg-red-200"
                                                onclick="return confirm('Supprimer ce commentaire ?')">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-400 py-8">Aucun commentaire signalé.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Gestion utilisateurs --}}
            <div x-show="tab === 'users'">
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Gestion des Utilisateurs</h2>
                    </div>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-xs text-gray-400 uppercase">
                                <th class="text-left px-6 py-4">Utilisateur</th>
                                <th class="text-left px-6 py-4">Rôle</th>
                                <th class="text-left px-6 py-4">Membre depuis</th>
                                <th class="text-left px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center font-bold text-gray-600">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                            <p class="text-gray-400 text-sm">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role === 'admin')
                                        <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full font-semibold uppercase">Admin</span>
                                    @elseif($user->role === 'auteur')
                                        <span class="bg-gray-200 text-gray-600 text-xs px-3 py-1 rounded-full font-semibold uppercase">Auteur</span>
                                    @else
                                        <span class="bg-gray-100 text-gray-500 text-xs px-3 py-1 rounded-full font-semibold uppercase">Lecteur</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.role', $user->id) }}" class="flex gap-2">
                                        @csrf @method('PUT')
                                        <select name="role" class="text-sm border border-gray-200 rounded-lg px-2 py-1">
                                            <option value="lecteur" {{ $user->role === 'lecteur' ? 'selected' : '' }}>Lecteur</option>
                                            <option value="auteur" {{ $user->role === 'auteur' ? 'selected' : '' }}>Auteur</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-sm font-semibold hover:bg-blue-200">
                                            Modifier
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection