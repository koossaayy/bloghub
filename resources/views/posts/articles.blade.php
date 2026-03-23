@extends('layouts.app')

@section('titre', 'Tous les Articles')

@section('contenu')

<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ __('Tous les Articles') }}</h1>
    <p class="text-gray-500">{{ $posts->total() }} {{ __('article(s) disponibles') }}</p>
</div>

{{-- Filtres --}}
<div class="flex flex-wrap gap-4 mb-8 items-center justify-between">
    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('posts.index') }}"
            class="{{ !request('category') && !request('search') ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90">
            {{ __('Tous') }}
        </a>
        @foreach($categories as $cat)
        <a href="{{ route('posts.index', ['category' => $cat->slug]) }}"
            class="{{ request('category') === $cat->slug ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-lg text-sm font-semibold hover:opacity-90">
            {{ $cat->nom }}
        </a>
        @endforeach
    </div>

    <form method="GET" action="{{ route('posts.index') }}" class="flex gap-2">
        <input type="text" name="search" placeholder="Rechercher..."
            value="{{ request('search') }}"
            class="px-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700">
            🔍
        </button>
    </form>
</div>

{{-- Tri --}}
<div class="flex gap-4 text-sm mb-6 border-b border-gray-200 pb-4">
    <a href="{{ route('posts.index', array_merge(request()->query(), ['sort' => 'recent'])) }}"
        class="{{ $sort === 'recent' ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-4 -mb-4' : 'text-gray-500 hover:text-blue-600' }}">
        {{ __('Plus récents') }}
    </a>
    <a href="{{ route('posts.index', array_merge(request()->query(), ['sort' => 'likes'])) }}"
        class="{{ $sort === 'likes' ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-4 -mb-4' : 'text-gray-500 hover:text-blue-600' }}">
        {{ __('Populaires ❤️') }}
    </a>
    <a href="{{ route('posts.index', array_merge(request()->query(), ['sort' => 'comments'])) }}"
        class="{{ $sort === 'comments' ? 'text-blue-600 font-semibold border-b-2 border-blue-600 pb-4 -mb-4' : 'text-gray-500 hover:text-blue-600' }}">
        {{ __('Tendances 💬') }}
    </a>
</div>

{{-- Grille articles --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    @forelse($posts as $post)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
        @if($post->image)
            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : Storage::url($post->image) }}"
                class="w-full h-48 object-cover">
        @else
            <div class="w-full h-48 bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center text-4xl">
                📄
            </div>
        @endif
        <div class="p-5">
            <div class="flex items-center gap-2 mb-3">
                <span class="bg-blue-100 text-blue-600 text-xs px-2 py-1 rounded-full uppercase font-semibold">
                    {{ $post->category->nom ?? '—' }}
                </span>
                @foreach($post->tags->take(2) as $tag)
                <span class="bg-gray-100 text-gray-500 text-xs px-2 py-1 rounded-full">
                    #{{ $tag->nom }}
                </span>
                @endforeach
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2 hover:text-blue-600 leading-tight">
                <a href="{{ route('posts.show', $post->slug) }}">{{ Str::limit($post->titre, 70) }}</a>
            </h3>
            <p class="text-gray-500 text-sm mb-4 leading-relaxed">
                {{ Str::limit(strip_tags($post->contenu), 100) }}
            </p>
            <div class="flex justify-between items-center pt-3 border-t border-gray-50">
                <div class="flex items-center gap-2">
                    <div class="w-7 h-7 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                    </div>
                    <span class="text-xs text-gray-500">{{ Str::limit($post->user->name, 15) }}</span>
                </div>
                <div class="flex items-center gap-3 text-xs text-gray-400">
                    <span>❤️ {{ $post->likes->count() }}</span>
                    <span>💬 {{ $post->comments->count() }}</span>
                    <span>{{ ceil(str_word_count(strip_tags($post->contenu)) / 200) }} {{ __('min') }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-16 text-gray-400">
        <p class="text-4xl mb-4">📭</p>
        <p class="text-xl font-semibold mb-2">{{ __('Aucun article trouvé') }}</p>
        <p class="text-sm">{{ __("Essayez avec d'autres mots-clés") }}</p>
    </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-4">
    {{ $posts->appends(request()->query())->links() }}
</div>

@endsection