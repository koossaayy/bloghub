<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogHub - Inscription</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">

<nav class="bg-white px-8 py-4 flex justify-between items-center">
    <a href="{{ route('accueil') }}" class="text-2xl font-bold italic text-gray-800">BlogHub</a>
    <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-blue-600">Accueil</a>
</nav>

<div class="min-h-screen flex items-center justify-center py-12 px-4">
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col md:flex-row w-full max-w-3xl">

        {{-- Partie gauche gradient --}}
<div class="w-full md:w-1/2 bg-gradient-to-br from-blue-400 to-green-400 p-8 flex flex-col justify-center">            <h2 class="text-4xl font-bold text-white leading-tight mb-6">
                Rejoignez la communauté BlogHub.
            </h2>
            <p class="text-white/80 text-lg">
                Partagez vos idées, publiez vos articles et connectez-vous avec des lecteurs du monde entier.
            </p>
        </div>

        {{-- Partie droite formulaire --}}
        <div class="w-full md:w-1/2 p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Créer un compte</h2>
            <p class="text-gray-500 mb-8">Rejoignez-nous en quelques secondes.</p>

            @if($errors->any())
                <div class="bg-red-100 text-red-600 px-4 py-3 rounded-lg mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Nom complet</label>
                    <input type="text" name="name" placeholder="Jean Dupont"
                        value="{{ old('name') }}"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Email</label>
                    <input type="email" name="email" placeholder="nom@exemple.fr"
                        value="{{ old('email') }}"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Mot de passe</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Confirmer le mot de passe</label>
                    <input type="password" name="password_confirmation" placeholder="••••••••"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                <div class="mb-6">
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Je suis</label>
                    <select name="role"
                        class="w-full px-4 py-3 bg-gray-100 rounded-lg border-0 focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="lecteur">Lecteur</option>
                        <option value="auteur">Auteur</option>
                    </select>
                </div>
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-green-500 text-white py-3 rounded-lg font-semibold hover:opacity-90">
                    Créer mon compte
                </button>
            </form>

            <p class="text-center text-gray-500 mt-6">
                Déjà un compte ?
                <a href="{{ route('login') }}" class="text-blue-500 font-semibold hover:underline">Connexion</a>
            </p>
        </div>
    </div>
</div>

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