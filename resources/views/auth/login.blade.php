<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogHub - Connexion</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

<nav class="bg-white px-8 py-4 flex justify-between items-center">
    <a href="{{ route('accueil') }}" class="text-2xl font-bold italic text-gray-800">BlogHub</a>
    <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-blue-600">Accueil</a>
</nav>

<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex w-full max-w-4xl">

        {{-- Partie gauche gradient --}}
        <div class="w-1/2 bg-gradient-to-br from-blue-400 to-green-400 p-12 flex flex-col justify-between">
            <div>
                <h2 class="text-4xl font-bold text-white leading-tight mb-6">
                    Redéfinissez votre expérience de lecture.
                </h2>
                <p class="text-white/80 text-lg">
                    Rejoignez une communauté d'esprits curieux et d'écrivains passionnés sur la plateforme éditoriale la plus raffinée du web.
                </p>
            </div>
            <div class="bg-white/20 rounded-xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-white/40 rounded-full"></div>
                <div>
                    <p class="text-white font-medium text-sm">"Une interface qui laisse enfin respirer les mots."</p>
                    <p class="text-white/70 text-xs">— Clara, Auteure sur BlogHub</p>
                </div>
            </div>
        </div>

        {{-- Partie droite formulaire --}}
        <div class="w-1/2 p-12">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Bon retour parmi nous</h2>
            <p class="text-gray-500 mb-8">Entrez vos identifiants pour accéder à votre espace.</p>

            @if($errors->any())
                <div class="bg-red-100 text-red-600 px-4 py-3 rounded-lg mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Email</label>
                    <input type="email" name="email" placeholder="nom@exemple.fr"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-xs font-semibold text-gray-500 uppercase">Mot de passe</label>
                        <a href="#" class="text-blue-500 text-sm hover:underline">Mot de passe oublié ?</a>
                    </div>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-green-500 text-white py-3 rounded-lg font-semibold hover:opacity-90">
                    Connexion
                </button>
            </form>

            <p class="text-center text-gray-500 mt-6">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-blue-500 font-semibold hover:underline">Inscription</a>
            </p>
        </div>
    </div>
</div>

{{-- Footer --}}
<footer class="text-center py-6">
    <p class="text-2xl font-bold italic text-gray-800 mb-3">BlogHub</p>
    <div class="flex justify-center gap-6 text-gray-400 text-sm mb-2">
        <a href="#">À propos</a>
        <a href="#">Confidentialité</a>
        <a href="#">Conditions</a>
        <a href="#">Contact</a>
    </div>
    <p class="text-gray-400 text-xs">© 2026 BlogHub. Tous droits réservés.</p>
</footer>

</body>
</html>