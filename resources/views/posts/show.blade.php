@extends('layouts.app')

@section('titre', $post->titre)

@section('contenu')

<div class="max-w-3xl mx-auto px-4">

    {{-- Breadcrumb --}}
    <div class="text-sm text-gray-400 mb-6">
        <a href="{{ route('accueil') }}" class="hover:text-blue-500">{{ __('Accueil') }}</a>
        <span class="mx-2">›</span>
        <a href="{{ route('posts.index') }}" class="hover:text-blue-500">{{ __('Articles') }}</a>
        <span class="mx-2">›</span>
        <span class="text-gray-600">{{ Str::limit($post->titre, 40) }}</span>
    </div>

    {{-- Catégorie & Tags --}}
    <div class="flex gap-2 mb-4">
        <span class="bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full uppercase font-semibold">
            {{ strtoupper($post->category->nom ?? 'Sans catégorie') }}
            @if($post->tags->count() > 0)
                &amp; {{ strtoupper($post->tags->first()->nom) }}
            @endif
        </span>
    </div>

    {{-- Titre --}}
    <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight">{{ $post->titre }}</h1>

    {{-- Auteur + Like + Partage --}}
    <div class="flex flex-wrap justify-between items-center mb-8 gap-4">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white font-bold shrink-0">
                {{ strtoupper(substr($post->user->name, 0, 1)) }}
            </div>
            <div>
                <p class="font-semibold text-gray-800">{{ $post->user->name }}</p>
                <p class="text-gray-400 text-sm">
                    {{ __('Publié le') }} {{ $post->created_at->format('d F Y') }} •
                    {{ ceil(str_word_count(strip_tags($post->contenu)) / 200) }} {{ __('min de lecture') }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button id="like-btn" onclick="toggleLike({{ $post->id }})"
                class="flex items-center gap-2 px-4 py-2 rounded-full border transition-all
                {{ auth()->check() && $post->likes->contains('user_id', auth()->id())
                    ? 'bg-red-50 border-red-200 text-red-500'
                    : 'bg-gray-50 border-gray-200 text-gray-500 hover:bg-red-50 hover:text-red-500' }}">
                ❤️ <span id="like-count">{{ $post->likes->count() }}</span>
            </button>
            <button onclick="partager()"
                class="text-gray-400 hover:text-blue-500 transition-colors text-xl px-3 py-2 rounded-full border border-gray-200 hover:border-blue-300"
                title="Partager cet article">
                ↗
            </button>
        </div>
    </div>

    {{-- Image --}}
    @if($post->image)
        <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}"
            class="w-full h-64 md:h-80 object-cover rounded-2xl mb-8">
    @endif

    {{-- Contenu --}}
    <div class="text-gray-700 leading-relaxed mb-8 text-base md:text-lg">
        @php
            $contenu = $post->contenu;
            $contenu = preg_replace('/^# (.+)$/m', '<h1 class="text-3xl font-bold text-gray-800 mt-8 mb-4">$1</h1>', $contenu);
            $contenu = preg_replace('/^## (.+)$/m', '<h2 class="text-2xl font-bold text-gray-800 mt-6 mb-3">$1</h2>', $contenu);
            $contenu = preg_replace('/^### (.+)$/m', '<h3 class="text-xl font-bold text-gray-800 mt-4 mb-2">$1</h3>', $contenu);
            $contenu = preg_replace('/^\> (.+)$/m', '<blockquote class="border-l-4 border-blue-300 pl-4 italic text-gray-600 my-4 bg-blue-50 py-2 rounded-r-lg">$1</blockquote>', $contenu);
            $contenu = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $contenu);
            $contenu = preg_replace('/\*(.+?)\*/', '<em>$1</em>', $contenu);
            $contenu = preg_replace('/^- (.+)$/m', '<li class="ml-4 list-disc mb-1">$1</li>', $contenu);
            $contenu = nl2br(e($contenu));
            $contenu = html_entity_decode($contenu, ENT_QUOTES, 'UTF-8');
        @endphp
        {!! $contenu !!}
    </div>

    {{-- Tags --}}
    <div class="flex flex-wrap gap-2 mb-12">
        @foreach($post->tags as $tag)
            <a href="{{ route('tags.show', $tag->slug) }}"
                class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full hover:bg-blue-100 hover:text-blue-600 transition-colors">
                #{{ $tag->nom }}
            </a>
        @endforeach
    </div>

    {{-- Articles similaires --}}
    @php
        $similaires = \App\Models\Post::where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->where('statut', 'publie')
            ->with(['user', 'category'])
            ->take(3)
            ->get();
    @endphp

    @if($similaires->count() > 0)
    <div class="mb-12">
        <h3 class="text-xl font-bold text-gray-800 mb-4">{{ __('Articles similaires') }}</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach($similaires as $similaire)
            <a href="{{ route('posts.show', $similaire->slug) }}"
                class="bg-white rounded-xl border border-gray-100 p-4 hover:shadow-md transition-shadow">
                @if($similaire->image)
                    <img src="{{ Str::startsWith($similaire->image, 'http') ? $similaire->image : Storage::url($similaire->image) }}"
                        class="w-full h-32 object-cover rounded-lg mb-3">
                @endif
                <span class="text-xs text-blue-600 font-semibold uppercase">{{ $similaire->category->nom }}</span>
                <p class="font-semibold text-gray-800 text-sm mt-1">{{ Str::limit($similaire->titre, 60) }}</p>
                <p class="text-gray-400 text-xs mt-1">{{ $similaire->user->name }}</p>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Section Commentaires --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-8">
            {{ __('La Conversation (') }}{{ $post->comments->where('approuve', true)->count() }})
        </h2>

        {{-- Formulaire commentaire --}}
        <div class="bg-gray-50 rounded-xl p-5 mb-8">
            <h3 class="font-semibold text-gray-700 mb-4">{{ __('Laissez votre avis') }}</h3>

            @if(session('success'))
                <div class="bg-green-100 text-green-600 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-600 px-4 py-3 rounded-lg mb-4 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('comments.store', $post->id) }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Nom complet') }}</label>
                        <input type="text" name="nom" placeholder="Ex: Jean Dupont"
                            value="{{ old('nom', auth()->user()->name ?? '') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Email') }}</label>
                        <input type="email" name="email" placeholder="nom@exemple.com"
                            value="{{ old('email', auth()->user()->email ?? '') }}"
                            class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm">
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Votre message') }}</label>
                    <textarea name="contenu" rows="4"
                        placeholder="Que pensez-vous de cet article ?"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm resize-none">{{ old('contenu') }}</textarea>
                </div>
                <button type="submit"
                    class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 text-sm">
                    {{ __('Publier mon commentaire') }}
                </button>
            </form>
        </div>

        {{-- Liste commentaires --}}
        @forelse($post->comments->where('approuve', true) as $comment)
        <div class="flex gap-4 mb-6 pb-6 border-b border-gray-100 last:border-0">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white font-bold shrink-0 text-sm">
                {{ strtoupper(substr($comment->nom, 0, 1)) }}
            </div>
            <div class="flex-1">
                <div class="flex justify-between items-center mb-1">
                    <div class="flex items-center gap-2">
                        <p class="font-semibold text-gray-800 text-sm">{{ $comment->nom }}</p>
                        @if($comment->user_id === $post->user_id)
                            <span class="bg-blue-100 text-blue-600 text-xs px-2 py-0.5 rounded-full font-semibold">{{ __('AUTEUR') }}</span>
                        @endif
                    </div>
                    <p class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</p>
                </div>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $comment->contenu }}</p>
            </div>
        </div>
        @empty
        <p class="text-gray-400 text-center py-8">{{ __('Soyez le premier à commenter !') }}</p>
        @endforelse
    </div>
</div>

{{-- Scripts --}}
<script>
async function toggleLike(postId) {
    const btn = document.getElementById('like-btn');
    const count = document.getElementById('like-count');

    try {
        const response = await fetch(`/posts/${postId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json', @json(__("Accept")): 'application/json'
            }
        });

        if (response.status === 401) {
            window.location.href = '/login';
            return;
        }

        const data = await response.json();
        count.textContent = data.count;

        if (data.liked) {
            btn.classList.add('bg-red-50', 'border-red-200', 'text-red-500');
            btn.classList.remove('bg-gray-50', 'border-gray-200', 'text-gray-500');
        } else {
            btn.classList.remove('bg-red-50', 'border-red-200', 'text-red-500');
            btn.classList.add('bg-gray-50', 'border-gray-200', 'text-gray-500');
        }
    } catch (error) {
        console.error( @json(__("Erreur like:")), error);
    }
}

function partager() {
    const url = window.location.href;
    const titre = document.title;

    if (navigator.share) {
        navigator.share({ title: titre, url: url }).catch(console.error);
    } else {
        // Méthode compatible HTTP
        const textArea = document.createElement('textarea');
        textArea.value = url;
        textArea.style.position = 'fixed';
        textArea.style.opacity = '0';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            document.execCommand('copy');
            const btn = document.querySelector('[onclick="partager()"]');
            const original = btn.innerHTML;
            btn.innerHTML =  @json(__("🔗 Copié !"));
            setTimeout(() => { btn.innerHTML = original; }, 2000);
        } catch (err) {
            // Si tout échoue, affiche l'URL dans une alerte
            prompt( @json(__("Copiez ce lien :")), url);
        }

        document.body.removeChild(textArea);
    }
}
</script>

@endsection