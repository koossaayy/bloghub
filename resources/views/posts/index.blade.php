@extends('layouts.app')

@section('titre', 'Accueil')

@section('contenu')

{{-- Hero --}}
<div class="bg-gray-100 rounded-2xl p-8 md:p-16 text-center mb-12">
    <h1 class="text-3xl md:text-5xl font-bold text-gray-800 mb-4 leading-tight">
        {{ __("L'excellence du") }} <span class="italic text-blue-500">{{ __('journalisme digital') }}</span> {{ __('à portée de clic.') }}
    </h1>
    <p class="text-gray-500 mb-8 text-base md:text-lg max-w-xl mx-auto">
        {{ __('Découvrez des perspectives uniques, des analyses approfondies et les dernières tendances du monde technologique et culturel.') }}
    </p>
    <form method="GET" action="{{ route('accueil') }}" class="flex flex-col sm:flex-row justify-center gap-2 max-w-lg mx-auto">
        <input type="text" name="search" placeholder="Rechercher un sujet, un auteur ou un article..."
            value="{{ request('search') }}"
            class="flex-1 px-5 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-400 bg-white text-sm">
        <button class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90 whitespace-nowrap">
            {{ __('Chercher') }}
        </button>
    </form>
</div>

<div style="display: flex; flex-wrap: wrap; gap: 2rem; align-items: flex-start;">

    {{-- Articles --}}
    <div style="flex: 1; min-width: 300px;">
        <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Dernières Publications') }}</h2>
            <div class="flex gap-4 text-sm">
                <a href="{{ route('accueil', array_merge(request()->query(), ['sort' => 'recent'])) }}"
                    class="{{ ($sort ?? 'recent') === 'recent' ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-500 hover:text-blue-600' }}">
                    {{ __('Plus récents') }}
                </a>
                <a href="{{ route('accueil', array_merge(request()->query(), ['sort' => 'likes'])) }}"
                    class="{{ ($sort ?? 'recent') === 'likes' ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-500 hover:text-blue-600' }}">
                    {{ __('Populaires') }}
                </a>
                <a href="{{ route('accueil', array_merge(request()->query(), ['sort' => 'comments'])) }}"
                    class="{{ ($sort ?? 'recent') === 'comments' ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-1' : 'text-gray-500 hover:text-blue-600' }}">
                    {{ __('Tendances') }}
                </a>
            </div>
        </div>

        {{-- Article featured (premier) --}}
        @if($posts->count() > 0)
        @php $featured = $posts->first(); @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-6 overflow-hidden hover:shadow-md transition-shadow">
            <div class="flex flex-col sm:flex-row gap-0">
                <div class="w-full sm:w-64 shrink-0 h-48 sm:h-auto">
                    @if($featured->image)
                        <img src="{{ Str::startsWith($featured->image, 'http') ? $featured->image : Storage::url($featured->image) }}"
                            class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center text-gray-400 text-4xl min-h-48">
                            📄
                        </div>
                    @endif
                </div>
                <div class="p-5 flex-1">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-blue-600 text-white text-xs px-3 py-1 rounded-full uppercase font-semibold">
                            {{ strtoupper($featured->category->nom ?? 'Sans catégorie') }}
                        </span>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-2 hover:text-blue-600 leading-tight">
                        <a href="{{ route('posts.show', $featured->slug) }}">{{ $featured->titre }}</a>
                    </h3>
                    <p class="text-gray-500 mb-4 text-sm md:text-base">{{ Str::limit(strip_tags($featured->contenu), 150) }}</p>
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($featured->user->name, 0, 1)) }}
                            </div>
                            <span class="text-sm text-gray-600 font-medium">{{ $featured->user->name }}</span>
                            <span class="text-gray-400 text-sm hidden sm:inline">• {{ $featured->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-400">
                            <span>❤️ {{ $featured->likes->count() }}</span>
                            <span>💬 {{ $featured->comments->count() }}</span>
                            <a href="{{ route('posts.show', $featured->slug) }}"
                                class="text-blue-500 font-semibold hover:underline">
                                {{ __('Lire →') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Autres articles --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            @foreach($posts->skip(1) as $post)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                @if($post->image)
                    <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}"
                        class="w-full h-44 object-cover">
                @else
                    <div class="w-full h-44 bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center text-gray-400 text-3xl">📄</div>
                @endif
                <div class="p-5">
                    <span class="bg-green-100 text-green-600 text-xs px-2 py-1 rounded-full uppercase font-semibold">
                        {{ $post->category->nom ?? '—' }}
                    </span>
                    <h3 class="text-lg font-bold text-gray-800 mt-2 mb-2 hover:text-blue-600 leading-tight">
                        <a href="{{ route('posts.show', $post->slug) }}">{{ Str::limit($post->titre, 60) }}</a>
                    </h3>
                    <p class="text-gray-500 text-sm mb-4">{{ Str::limit(strip_tags($post->contenu), 80) }}</p>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($post->user->name, 0, 1)) }}
                            </div>
                            <span class="text-xs text-gray-500">{{ Str::limit($post->user->name, 15) }}</span>
                        </div>
                        <span class="text-xs text-gray-400">{{ ceil(str_word_count(strip_tags($post->contenu)) / 200) }} {{ __('MIN LECTURE') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $posts->appends(request()->query())->links() }}
        </div>
    </div>

    {{-- Sidebar --}}
    <div style="width: 18rem; flex-shrink: 0; min-width: 280px;">

        {{-- Catégories Populaires --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">{{ __('Catégories Populaires') }}</h3>
            @foreach($categories as $cat)
            <a href="{{ route('categories.show', $cat->slug) }}"
                class="flex justify-between items-center py-2 border-b border-gray-50 text-gray-600 hover:text-blue-600">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                    <span class="text-sm">{{ $cat->nom }}</span>
                </div>
                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full font-semibold">{{ $cat->posts_count }}</span>
            </a>
            @endforeach
        </div>

        {{-- Tags Tendances --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">{{ __('Tags Tendances') }}</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($tags as $tag)
                <a href="{{ route('tags.show', $tag->slug) }}"
                    class="bg-gray-100 text-gray-600 text-sm px-3 py-1 rounded-full hover:bg-blue-100 hover:text-blue-600 transition-colors">
                    #{{ $tag->nom }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Auteurs Vedettes --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="font-bold text-gray-800 mb-4">{{ __('Auteurs Vedettes') }}</h3>
            @foreach(\App\Models\User::withCount('posts')->where('role', 'auteur')->orWhere('role', 'admin')->orderByDesc('posts_count')->take(3)->get() as $auteur)
            <div class="flex items-center gap-3 py-2 border-b border-gray-50">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                    {{ strtoupper(substr($auteur->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-gray-800 text-sm">{{ $auteur->name }}</p>
                    <p class="text-gray-400 text-xs">{{ $auteur->posts_count }} {{ __('article(s)') }}</p>
                </div>
            </div>
            @endforeach
            <a href="{{ route('posts.index') }}" class="block text-center text-blue-500 text-sm mt-4 hover:underline">{{ __('Voir tous les articles') }}</a>
        </div>

        {{-- Newsletter --}}
        <div class="bg-gradient-to-br from-blue-500 to-green-500 rounded-xl p-6">
            <h3 class="font-bold text-white mb-2">{{ __('Newsletter') }}</h3>
            <p class="text-white/80 text-sm mb-4">{{ __('Recevez le meilleur de BlogHub directement dans votre boite mail chaque lundi matin.') }}</p>
            @if(session('newsletter_success'))
                <div class="bg-white/20 text-white px-4 py-3 rounded-lg text-sm font-semibold text-center">
                    ✅ {{ session('newsletter_success') }}
                </div>
            @else
                <form method="POST" action="{{ route('newsletter.subscribe') }}">
                    @csrf
                    <input type="email" name="email" placeholder="votre@email.com"
                        class="w-full px-3 py-2 rounded-lg text-gray-700 text-sm focus:outline-none mb-3"
                        required>
                    <button type="submit"
                        class="w-full bg-white text-blue-600 py-2 rounded-lg font-semibold text-sm hover:bg-gray-100 transition-colors">
                        {{ __("S'abonner") }}
                    </button>
                </form>
            @endif
        </div>

    </div>
</div>

@endsection