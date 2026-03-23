@extends('layouts.app')
@section('titre', 'À propos de BlogHub')
@section('contenu')

<div class="max-w-4xl mx-auto">

    {{-- Hero --}}
    <div class="bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl p-12 text-center mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">{{ __('À propos de BlogHub') }}</h1>
        <p class="text-white/80 text-lg max-w-2xl mx-auto">
            {{ __('La plateforme éditoriale de référence pour les voix africaines qui ont quelque chose à dire.') }}
        </p>
    </div>

    {{-- Mission --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl">🎯</div>
            <h2 class="text-2xl font-bold text-gray-800">{{ __('Notre Mission') }}</h2>
        </div>
        <p class="text-gray-600 leading-relaxed mb-4">
            {{ __("BlogHub est née d'une conviction simple : chaque voix mérite d'être entendue. Nous avons créé une plateforme où les écrivains, journalistes, entrepreneurs et penseurs africains peuvent partager leurs idées, analyses et perspectives avec le monde entier.") }}
        </p>
        <p class="text-gray-600 leading-relaxed">
            {{ __("Notre mission est de démocratiser l'accès à l'information de qualité et de donner aux auteurs camerounais et africains les outils nécessaires pour se faire entendre à l'échelle internationale.") }}
        </p>
    </div>

    {{-- Valeurs --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <div class="text-4xl mb-4">✍️</div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ __('Excellence Éditoriale') }}</h3>
            <p class="text-gray-500 text-sm">{{ __('Nous valorisons la qualité du contenu et encourageons nos auteurs à produire des articles approfondis et bien documentés.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <div class="text-4xl mb-4">🌍</div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ __('Ancrage Africain') }}</h3>
            <p class="text-gray-500 text-sm">{{ __('Fiers de nos racines camerounaises, nous célébrons la richesse culturelle et intellectuelle du continent africain.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
            <div class="text-4xl mb-4">🤝</div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">{{ __('Communauté') }}</h3>
            <p class="text-gray-500 text-sm">{{ __("BlogHub c'est avant tout une communauté de passionnés qui s'entraident, se lisent et se commentent mutuellement.") }}</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl p-8 mb-8">
        <h2 class="text-2xl font-bold text-white text-center mb-8">{{ __('BlogHub en chiffres') }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            <div>
                <p class="text-4xl font-bold text-blue-400 mb-1">{{ \App\Models\Post::where('statut','publie')->count() }}+</p>
                <p class="text-gray-400 text-sm">{{ __('Articles publiés') }}</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-green-400 mb-1">{{ \App\Models\User::count() }}+</p>
                <p class="text-gray-400 text-sm">{{ __('Membres actifs') }}</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-yellow-400 mb-1">{{ \App\Models\Category::count() }}</p>
                <p class="text-gray-400 text-sm">{{ __('Catégories') }}</p>
            </div>
            <div>
                <p class="text-4xl font-bold text-red-400 mb-1">{{ \App\Models\Comment::where('approuve',true)->count() }}+</p>
                <p class="text-gray-400 text-sm">{{ __('Commentaires') }}</p>
            </div>
        </div>
    </div>

    {{-- Équipe --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">{{ __("L'équipe fondatrice") }}</h2>
        <div class="flex items-center gap-6">
            <img src="https://i.ibb.co/Kzp3Yhsc/CALEBWhats-App-Image-2026-03-20-at-00-49-09.jpg"
                class="w-20 h-20 rounded-full object-cover border-4 border-blue-100">
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ __('Dassi Caleb DAONY') }}</h3>
                <p class="text-blue-600 font-semibold mb-2">{{ __('Fondateur & Développeur Principal') }}</p>
                <p class="text-gray-500 text-sm">{{ __('Développeur passionné basé à Yaoundé, Cameroun. Créateur de BlogHub avec la vision de donner une voix aux talents africains du numérique.') }}</p>
            </div>
        </div>
    </div>

    {{-- CTA --}}
    <div class="bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl p-8 text-center">
        <h2 class="text-2xl font-bold text-white mb-4">{{ __("Rejoignez l'aventure BlogHub !") }}</h2>
        <p class="text-white/80 mb-6">{{ __('Devenez auteur et partagez vos idées avec notre communauté grandissante.') }}</p>
        <a href="{{ route('register') }}"
            class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition-colors inline-block">
            {{ __('Créer mon compte gratuitement') }}
        </a>
    </div>

</div>

@endsection