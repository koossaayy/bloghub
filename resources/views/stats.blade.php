@extends('layouts.app')

@section('titre', 'Statistiques')

@section('contenu')
    <div class="max-w-4xl mx-auto py-12 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ __('Statistiques du blog') }}</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-4xl font-bold text-blue-600">{{ $stats['posts'] }}</p>
                <p class="text-gray-500 mt-2">{{ __('Articles') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-4xl font-bold text-green-600">{{ $stats['categories'] }}</p>
                <p class="text-gray-500 mt-2">{{ __('Catégories') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-4xl font-bold text-purple-600">{{ $stats['tags'] }}</p>
                <p class="text-gray-500 mt-2">{{ __('Tags') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-4xl font-bold text-orange-600">{{ $stats['comments'] }}</p>
                <p class="text-gray-500 mt-2">{{ __('Commentaires') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-4xl font-bold text-pink-600">{{ $stats['users'] }}</p>
                <p class="text-gray-500 mt-2">{{ __('Utilisateurs') }}</p>
            </div>

            <div class="bg-white rounded-xl shadow p-6 text-center">
                <p class="text-4xl font-bold text-pink-600">{{ $stats['users'] }}</p>
                <p class="text-gray-500 mt-2">{{ __('Utilisateurs') }}</p>
            </div>

        </div>
    </div>
@endsection
