@extends('layouts.app')

@section('titre', 'Mon Profil')

@section('contenu')

<div class="max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">{{ __('Mon Profil') }}</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-600 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    {{-- Infos personnelles --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-6">{{ __('Informations personnelles') }}</h2>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="flex items-center gap-6 mb-6">
                <div class="w-20 h-20 bg-gray-300 rounded-full flex items-center justify-center text-2xl font-bold text-gray-600">
                    @if($user->avatar)
                        <img src="{{ Storage::url($user->avatar) }}" class="w-20 h-20 rounded-full object-cover">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div>
                    <label class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg cursor-pointer hover:bg-gray-200 font-semibold text-sm">
                        {{ __("Changer l'avatar") }}
                        <input type="file" name="avatar" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Nom complet') }}</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Bio') }}</label>
                <textarea name="bio" rows="3"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('bio', $user->bio) }}</textarea>
            </div>
            <button type="submit"
                class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-6 py-3 rounded-lg font-semibold hover:opacity-90">
                {{ __('Mettre à jour') }}
            </button>
        </form>
    </div>

    {{-- Mot de passe --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
        <h2 class="text-xl font-bold text-gray-800 mb-6">{{ __('Changer le mot de passe') }}</h2>

        <form method="POST" action="{{ route('profile.password') }}">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Mot de passe actuel') }}</label>
                <input type="password" name="current_password"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Nouveau mot de passe') }}</label>
                <input type="password" name="password"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-6">
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Confirmer le mot de passe') }}</label>
                <input type="password" name="password_confirmation"
                    class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit"
                class="bg-gray-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-gray-900">
                {{ __('Changer le mot de passe') }}
            </button>
        </form>
    </div>
</div>

@endsection