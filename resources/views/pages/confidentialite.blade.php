@extends('layouts.app')
@section('titre', 'Politique de confidentialité')
@section('contenu')

<div class="max-w-3xl mx-auto">

    <div class="bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl p-10 text-center mb-10">
        <h1 class="text-4xl font-bold text-white mb-3">{{ __('Politique de Confidentialité') }}</h1>
        <p class="text-white/80">{{ __('Dernière mise à jour : Mars 2026') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-8">

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-sm">1</span>
                {{ __('Collecte des données') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __("BlogHub collecte uniquement les données nécessaires au bon fonctionnement de la plateforme : nom, adresse email et mot de passe lors de l'inscription. Ces informations sont utilisées exclusivement pour vous identifier et personnaliser votre expérience.") }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-sm">2</span>
                {{ __('Utilisation des données') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __('Vos données personnelles sont utilisées pour : créer et gérer votre compte, publier vos articles et commentaires, vous envoyer des notifications importantes concernant votre compte. Nous ne vendons jamais vos données à des tiers.') }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-sm">3</span>
                {{ __('Cookies') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __('BlogHub utilise des cookies de session pour maintenir votre connexion active. Ces cookies sont essentiels au fonctionnement du site et ne collectent aucune information personnelle supplémentaire.') }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-sm">4</span>
                {{ __('Sécurité') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __("Vos mots de passe sont chiffrés avec l'algorithme bcrypt. Nous mettons en place des mesures de sécurité régulières pour protéger vos données contre tout accès non autorisé, modification ou divulgation.") }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 font-bold text-sm">5</span>
                {{ __('Vos droits') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __("Vous avez le droit d'accéder, modifier ou supprimer vos données personnelles à tout moment depuis votre espace profil. Pour toute demande, contactez-nous à") }} 
                <a href="mailto:calebdaony@gmail.com" class="text-blue-600 hover:underline">calebdaony@gmail.com</a>.
            </p>
        </div>

        <div class="bg-blue-50 rounded-xl p-5">
            <p class="text-blue-700 text-sm">
                {{ __('📧 Pour toute question relative à votre vie privée, contactez notre équipe à') }} 
                <a href="mailto:calebdaony@gmail.com" class="font-semibold hover:underline">calebdaony@gmail.com</a>
            </p>
        </div>
    </div>
</div>

@endsection