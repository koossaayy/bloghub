<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('BlogHub -') }} @yield('titre', 'Plateforme de blog')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans">

    {{-- Navbar --}}
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 py-3">
            <div class="flex items-center justify-between">

                {{-- Logo --}}
                <a href="{{ route('accueil') }}" class="text-2xl font-bold italic text-gray-800">
                    {{ __('BlogHub') }}
                </a>

                {{-- Burger mobile --}}
                <button id="menu-toggle" class="md:hidden text-gray-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Liens desktop --}}
                <div class="hidden md:flex items-center gap-6">
                    <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-blue-600">{{ __('Accueil') }}</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('Articles') }}</a>
                    <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('Catégories') }}</a>
                    <a href="{{ route('stats') }}" class="text-gray-600 hover:text-blue-600">{{ __('Statistiques') }}</a>
                </div>

                {{-- Auth desktop --}}
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.index') }}" class="text-gray-600 hover:text-blue-600">{{ __('Administration') }}</a>
                        @endif
                        @if(auth()->user()->isAuteur() || auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600">{{ __('Dashboard') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700 hover:bg-gray-300">
                                {{ __('Déconnexion') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600">{{ __('Connexion') }}</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 py-2 rounded-lg hover:opacity-90">
                            {{ __('Inscription') }}
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Menu mobile --}}
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 border-t border-gray-100 pt-4">
                <div class="flex flex-col gap-3">
                    <a href="{{ route('accueil') }}" class="text-gray-600 hover:text-blue-600 py-1">{{ __('Accueil') }}</a>
                    <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-blue-600 py-1">{{ __('Articles') }}</a>
                    <a href="{{ route('categories.index') }}" class="text-gray-600 hover:text-blue-600 py-1">{{ __('Catégories') }}</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.index') }}" class="text-gray-600 hover:text-blue-600 py-1">{{ __('Administration') }}</a>
                        @endif
                        @if(auth()->user()->isAuteur() || auth()->user()->isAdmin())
                            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-600 py-1">{{ __('Dashboard') }}</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="bg-gray-200 px-4 py-2 rounded-lg text-gray-700 w-full text-left mt-1">
                                {{ __('Déconnexion') }}
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 py-1">{{ __('Connexion') }}</a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 py-2 rounded-lg text-center mt-1">
                            {{ __('Inscription') }}
                        </a>
                    @endauth
                </div>
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
            <p class="text-2xl font-bold italic text-gray-800 mb-4">{{ __('BlogHub') }}</p>
            <div class="flex justify-center gap-6 text-gray-500 text-sm mb-4 flex-wrap">
                <a href="{{ route('apropos') }}" class="hover:text-blue-600">{{ __('À propos') }}</a>
<a href="{{ route('confidentialite') }}" class="hover:text-blue-600">{{ __('Confidentialité') }}</a>
<a href="{{ route('conditions') }}" class="hover:text-blue-600">{{ __('Conditions') }}</a>
<a href="{{ route('contact') }}" class="hover:text-blue-600">{{ __('Contact') }}</a>
            </div>
            <p class="text-gray-400 text-sm">{{ __('2026 BlogHub. Tous droits réservés.') }}</p>
        </div>
    </footer>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        document.getElementById('menu-toggle').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });
    </script>

</body>
</html>