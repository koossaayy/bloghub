@extends('layouts.app')

@section('titre', 'Modifier l\'article')

@section('contenu')

<div class="flex gap-8">

    {{-- Sidebar --}}
    <div class="w-56 shrink-0">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <p class="text-xs text-gray-400 uppercase font-semibold mb-1">{{ __('Espace Auteur') }}</p>
            <p class="text-sm text-gray-500 mb-6">{{ __('Gérez vos publications') }}</p>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    {{ __('📊 Tableau de bord') }}
                </a>
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 font-semibold">
                    {{ __('📄 Mes Articles') }}
                </a>
                <a href="{{ route('posts.create') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    {{ __('➕ Nouvel Article') }}
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    {{ __('👤 Mon Profil') }}
                </a>
            </nav>
        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="flex-1">

        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-sm text-gray-400">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-500">{{ __('Articles') }}</a>
                    <span class="mx-2">›</span> {{ __('Modifier') }}
                </p>
                <h1 class="text-2xl font-bold text-gray-800">{{ __("Modifier l'article") }}</h1>
            </div>
            <div class="flex gap-3">
                <button form="form-edit" type="submit"
                    class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg font-semibold hover:bg-gray-200">
                    {{ __('Enregistrer') }}
                </button>
                <button form="form-edit" type="submit"
                    class="bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700">
                    {{ __('Publier') }}
                </button>
            </div>
        </div>

        @if($errors->any())
            <div class="bg-red-100 text-red-600 px-4 py-3 rounded-lg mb-6">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="form-edit" method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="flex gap-6">
                <div class="flex-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-3">{{ __('Titre') }}</label>
                        <input type="text" name="titre" value="{{ old('titre', $post->titre) }}"
                            class="w-full text-2xl font-bold text-gray-800 border-0 focus:outline-none focus:ring-0 mb-4">
                        <hr class="border-gray-100 mb-4">
                        <textarea name="contenu" rows="16"
                            class="w-full border-0 focus:outline-none focus:ring-0 text-gray-700 resize-none">{{ old('contenu', $post->contenu) }}</textarea>
                    </div>
                </div>

                <div class="w-64 shrink-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">

                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-2">{{ __('Catégorie') }}</label>
                        <select name="category_id"
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-4">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ $post->category_id == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>

                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-2">{{ __('Tags') }}</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full cursor-pointer hover:bg-blue-100">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                        class="hidden"
                                        {{ $post->tags->contains($tag->id) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600">{{ $tag->nom }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-3">{{ __('Image de couverture') }}</label>
                        @if($post->image)
                            <img src="{{ Storage::url($post->image) }}" class="w-full h-32 object-cover rounded-lg mb-3">
                        @endif
                        <label class="border-2 border-dashed border-gray-200 rounded-xl p-6 flex flex-col items-center cursor-pointer hover:border-blue-400">
                            <span class="text-2xl mb-1">☁️</span>
                            <span class="text-gray-600 font-semibold text-sm">{{ __("Changer l'image") }}</span>
                            <input type="file" name="image" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection