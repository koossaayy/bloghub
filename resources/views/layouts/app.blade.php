<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogHub - @yield('titre', 'Plateforme de blog')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('accueil') }}" class="text-2xl font-bold italic text-gray-800">
                BlogHub
            </a>

            {{-- Liens --}}
            <div class="flex items-center gap-6">
                <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-blue-600">Accueil</a>
                <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-blue-600">Articles</a>
                <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-blue-600">Catégories</a>
            </div>

            {{-- Auth --}}
            <div class="flex items-center gap-3">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.index') }}" class="text-gray-600 hover:text-blue-600">Administration</a>
                    @endif
                    @if(auth()->user()->isAuteur() || auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600">Dashboard</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-300">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 py-2 rounded-lg hover:opacity-90">
                        Inscription
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Messages flash --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto mt-4 px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    {{-- Contenu --}}
    <main class="max-w-7xl mx-auto px-4 py-8">
        @yield('contenu')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t border-gray-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 py-8 text-center">
            <p class="text-2xl font-bold italic text-gray-800 mb-4">BlogHub</p>
            <div class="flex justify-center gap-6 text-gray-500 text-sm mb-4">
                <a href="#" class="hover:text-blue-600">À propos</a>
                <a href="#" class="hover:text-blue-600">Confidentialité</a>
                <a href="#" class="hover:text-blue-600">Conditions</a>
                <a href="#" class="hover:text-blue-600">Contact</a>
            </div>
            <p class="text-gray-400 text-sm">© 2026 BlogHub. Tous droits réservés.</p>
        </div>
    </footer>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>