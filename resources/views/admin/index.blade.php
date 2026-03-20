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
                <a href="{{ route('posts.mes') }}"
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

        {{-- Prêt à partager --}}
        <div class="mt-4 bg-blue-50 rounded-xl p-4">
            <p class="text-sm font-semibold text-gray-700 mb-3">Prêt à partager ?</p>
            <a href="{{ route('posts.create') }}"
                class="w-full block text-center bg-blue-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-blue-700 text-sm">
                Publier maintenant
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
                <div class="relative">
                    <span class="text-2xl cursor-pointer">🔔</span>
                    @if($postEnAttente->count() > 0)
                        <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                            {{ $postEnAttente->count() }}
                        </span>
                    @endif
                </div>
                <div class="text-right">
                    <p class="font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                </div>
                <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4 mb-8">
            {{-- Taux approbation --}}
            <div class="bg-white rounded-xl border-l-4 border-blue-500 p-6 flex justify-between items-center shadow-sm">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Taux d'approbation</p>
                    @php
                        $totalPosts = \App\Models\Post::count();
                        $publies = \App\Models\Post::where('statut', 'publie')->count();
                        $taux = $totalPosts > 0 ? round(($publies / $totalPosts) * 100, 1) : 0;
                    @endphp
                    <p class="text-3xl font-bold text-gray-800">{{ $taux }}%</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">✅</div>
            </div>

            {{-- Nouveaux auteurs --}}
            <div class="bg-white rounded-xl border-l-4 border-green-500 p-6 flex justify-between items-center shadow-sm">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Nouveaux Auteurs</p>
                    <p class="text-3xl font-bold text-gray-800">+{{ $users->where('role', 'auteur')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl">👥</div>
            </div>

            {{-- Alertes critiques --}}
            <div class="bg-white rounded-xl border-l-4 border-red-500 p-6 flex justify-between items-center shadow-sm">
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold mb-1">Alertes Critiques</p>
                    <p class="text-3xl font-bold text-gray-800">{{ str_pad($commentsSignales->count(), 2, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-2xl">⚠️</div>
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
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
                    <div class="flex justify-between items-center px-6 py-4 border-b border-gray-100">
                        <h2 class="font-bold text-gray-800">Révision des publications</h2>
                        <button class="flex items-center gap-2 text-sm text-gray-500 bg-gray-100 px-3 py-1.5 rounded-lg hover:bg-gray-200">
                            ⚙️ Filtrer
                        </button>
                    </div>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-xs text-gray-400 uppercase">
                                <th class="text-left px-6 py-4">Article</th>
                                <th class="text-left px-6 py-4">Auteur</th>
                                <th class="text-left px-6 py-4">Date de soumission</th>
                                <th class="text-left px-6 py-4">Catégorie</th>
                                <th class="text-left px-6 py-4">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($postEnAttente as $post)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 shrink-0">
                                            @if($post->image)
                                                <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}"
                                                    class="w-12 h-12 object-cover rounded-lg">
                                            @else
                                                📄
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ Str::limit($post->titre, 45) }}</p>
                                            <p class="text-xs text-gray-400">
                                                {{ str_word_count(strip_tags($post->contenu)) }} mots •
                                                Lecture {{ ceil(str_word_count(strip_tags($post->contenu)) / 200) }} min
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-xs font-bold text-white">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-700">{{ $post->user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</td>
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
            <div x-show="tab === 'comments'" x-cloak>
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
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
                                                onclick="return confirm('Supprimer ?')">
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
            <div x-show="tab === 'users'" x-cloak>
                <div class="bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-gray-800">Gestion des Utilisateurs</h2>
                        <div class="relative">
                            <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                            <input type="text" placeholder="Rechercher un utilisateur..."
                                class="pl-8 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 w-64">
                        </div>
                    </div>
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-xs text-gray-400 uppercase">
                                <th class="text-left px-6 py-4">Utilisateur</th>
                                <th class="text-left px-6 py-4">Rôle</th>
                                <th class="text-left px-6 py-4">Statut</th>
                                <th class="text-left px-6 py-4">Dernière activité</th>
                                <th class="text-left px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-t border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-white text-sm
                                            {{ $user->role === 'admin' ? 'bg-blue-500' : ($user->role === 'auteur' ? 'bg-green-500' : 'bg-gray-400') }}">
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
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        <span class="text-sm text-gray-600">En ligne</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-gray-400 text-sm">{{ $user->updated_at->diffForHumans() }}</td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.role', $user->id) }}" class="flex gap-2">
                                        @csrf @method('PUT')
                                        <select name="role" class="text-sm border border-gray-200 rounded-lg px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400">
                                            <option value="lecteur" {{ $user->role === 'lecteur' ? 'selected' : '' }}>Lecteur</option>
                                            <option value="auteur" {{ $user->role === 'auteur' ? 'selected' : '' }}>Auteur</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button class="bg-blue-100 text-blue-600 px-3 py-1 rounded-lg text-sm font-semibold hover:bg-blue-200">
                                            ✓
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