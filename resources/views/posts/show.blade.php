@extends('layouts.app')

@section('titre', $post->titre)

@section('contenu')

<div class="max-w-3xl mx-auto">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-400 mb-6">
        <a href="{{ route('accueil') }}" class="hover:text-blue-500">Accueil</a>
        <span class="mx-2">›</span>
        <a href="{{ route('posts.index') }}" class="hover:text-blue-500">Articles</a>
        <span class="mx-2">›</span>
        <span class="text-gray-600">{{ Str::limit($post->titre, 40) }}</span>
    </div>

    {{-- Catégorie & Tags --}}
    <div class="flex gap-2 mb-4">
        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full uppercase font-semibold">
            {{ $post->category->nom ?? 'Sans catégorie' }}
        </span>
    </div>

    {{-- Titre --}}
    <h1 class="text-4xl font-bold text-gray-800 mb-4">{{ $post->titre }}</h1>

    {{-- Auteur + Like --}}
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold">
                {{ strtoupper(substr($post->user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                <p class="text-gray-400 text-sm">Publié le {{ $post->created_at->format('d F Y') }}</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('posts.like', $post->id) }}">
                @csrf
                <button class="flex items-center gap-2 text-gray-500 hover:text-red-500">
                    ❤️ <span>{{ $post->likes->count() }}</span>
                </button>
            </form>
        </div>
    </div>

    {{-- Image --}}
    @if($post->image)
        <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}" class="w-32 h-24 object-cover rounded-lg">
    @endif

    {{-- Contenu --}}
    <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
        {!! nl2br(e($post->contenu)) !!}
    </div>

    {{-- Tags --}}
    <div class="flex flex-wrap gap-2 mb-12">
        @foreach($post->tags as $tag)
            <a href="{{ route('tags.show', $tag->slug) }}"
                class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full hover:bg-blue-100 hover:text-blue-600">
                #{{ $tag->nom }}
            </a>
        @endforeach
    </div>

    {{-- Commentaires --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">
            La Conversation ({{ $post->comments->where('approuve', true)->count() }})
        </h2>

        {{-- Formulaire commentaire --}}
        <div class="bg-gray-50 rounded-xl p-6 mb-8">
            <h3 class="font-semibold text-gray-700 mb-4">Laissez votre avis</h3>

            @if(session('success'))
                <div class="bg-green-100 text-green-600 px-4 py-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nom complet</label>
                        <input type="text" name="nom" placeholder="Ex: Jean Dupont"
                            value="{{ old('nom', auth()->user()->name ?? '') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Email</label>
                        <input type="email" name="email" placeholder="nom@exemple.com"
                            value="{{ old('email', auth()->user()->email ?? '') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Votre message</label>
                    <textarea name="contenu" rows="4" placeholder="Que pensez-vous de cet article ?"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('contenu') }}</textarea>
                </div>
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90">
                    Publier mon commentaire
                </button>
            </form>
        </div>

        {{-- Liste commentaires --}}
        @foreach($post->comments->where('approuve', true) as $comment)
        <div class="flex gap-4 mb-6 pb-6 border-b border-gray-100">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 font-bold shrink-0">
                {{ strtoupper(substr($comment->nom, 0, 1)) }}
            </div>
            <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-gray-800">{{ $comment->nom }}</p>
                        @if($comment->user_id === $post->user_id)
                            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded-full">AUTEUR</span>
                        @endif
                    </div>
                    <p class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <p class="text-gray-600">{{ $comment->contenu }}</p>
            </div>
        </div>
        @endforeach

    </div>
</div>

@endsection