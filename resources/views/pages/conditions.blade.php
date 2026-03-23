@extends('layouts.app')
@section('titre', "Conditions d'utilisation")
@section('contenu')

<div class="max-w-3xl mx-auto">

    <div class="bg-gradient-to-br from-blue-500 to-green-500 rounded-2xl p-10 text-center mb-10">
        <h1 class="text-4xl font-bold text-white mb-3">{{ __("Conditions d'Utilisation") }}</h1>
        <p class="text-white/80">{{ __('Dernière mise à jour : Mars 2026') }}</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 space-y-8">

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 font-bold text-sm">1</span>
                {{ __('Acceptation des conditions') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __("En accédant à BlogHub, vous acceptez d'être lié par ces conditions d'utilisation. Si vous n'acceptez pas ces conditions, veuillez ne pas utiliser notre plateforme.") }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 font-bold text-sm">2</span>
                {{ __('Utilisation de la plateforme') }}
            </h2>
            <p class="text-gray-600 leading-relaxed mb-3">{{ __('Vous vous engagez à :') }}</p>
            <ul class="list-none space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><span class="text-green-500 mt-1">✓</span> {{ __('Fournir des informations exactes lors de votre inscription') }}</li>
                <li class="flex items-start gap-2"><span class="text-green-500 mt-1">✓</span> {{ __('Publier uniquement du contenu original et légal') }}</li>
                <li class="flex items-start gap-2"><span class="text-green-500 mt-1">✓</span> {{ __("Respecter les droits d'auteur et la propriété intellectuelle") }}</li>
                <li class="flex items-start gap-2"><span class="text-green-500 mt-1">✓</span> {{ __('Maintenir un comportement respectueux envers la communauté') }}</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 font-bold text-sm">3</span>
                {{ __('Contenu interdit') }}
            </h2>
            <p class="text-gray-600 leading-relaxed mb-3">{{ __('Il est strictement interdit de publier :') }}</p>
            <ul class="list-none space-y-2 text-gray-600">
                <li class="flex items-start gap-2"><span class="text-red-500 mt-1">✗</span> {{ __('Du contenu haineux, discriminatoire ou offensant') }}</li>
                <li class="flex items-start gap-2"><span class="text-red-500 mt-1">✗</span> {{ __('Des informations fausses ou trompeuses') }}</li>
                <li class="flex items-start gap-2"><span class="text-red-500 mt-1">✗</span> {{ __("Du contenu protégé par droits d'auteur sans autorisation") }}</li>
                <li class="flex items-start gap-2"><span class="text-red-500 mt-1">✗</span> {{ __('Du spam ou contenu publicitaire non sollicité') }}</li>
            </ul>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 font-bold text-sm">4</span>
                {{ __('Propriété intellectuelle') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __('Les auteurs conservent tous les droits sur leurs contenus publiés sur BlogHub. En publiant sur notre plateforme, vous accordez à BlogHub une licence non exclusive pour afficher et distribuer votre contenu sur la plateforme.') }}
            </p>
        </div>

        <div>
            <h2 class="text-xl font-bold text-gray-800 mb-3 flex items-center gap-2">
                <span class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600 font-bold text-sm">5</span>
                {{ __('Suspension de compte') }}
            </h2>
            <p class="text-gray-600 leading-relaxed">
                {{ __("BlogHub se réserve le droit de suspendre ou supprimer tout compte qui violerait ces conditions d'utilisation, sans préavis ni remboursement.") }}
            </p>
        </div>

        <div class="bg-green-50 rounded-xl p-5">
            <p class="text-green-700 text-sm">
                {{ __('📧 Pour toute question, contactez-nous à') }} 
                <a href="mailto:calebdaony@gmail.com" class="font-semibold hover:underline">calebdaony@gmail.com</a>
            </p>
        </div>
    </div>
</div>

@endsection