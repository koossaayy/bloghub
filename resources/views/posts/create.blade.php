@extends('layouts.app')

@section('titre', 'Nouvel Article')

@section('contenu')

<div class="flex gap-8">

    {{-- Sidebar --}}
    <div class="w-56 shrink-0">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            {{-- Avatar --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-green-400 rounded-full flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-semibold">{{ __('Espace Auteur') }}</p>
                    <p class="text-sm text-gray-500">{{ __('Gérez vos publications') }}</p>
                </div>
            </div>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    {{ __('📊 Tableau de bord') }}
                </a>
                <a href="{{ route('posts.mes') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    {{ __('📄 Mes Articles') }}
                </a>
                <a href="{{ route('posts.create') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-blue-50 text-blue-600 font-semibold">
                    {{ __('➕ Nouvel Article') }}
                </a>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-gray-600 hover:bg-gray-50">
                    {{ __('👤 Mon Profil') }}
                </a>
            </nav>
        </div>
        <div class="mt-4">
            <button onclick="document.getElementById('form-article').submit()"
                class="w-full block text-center bg-gradient-to-r from-blue-500 to-green-500 text-white px-4 py-3 rounded-lg font-semibold hover:opacity-90">
                {{ __('✏️ Publier maintenant') }}
            </button>
        </div>
    </div>

    {{-- Contenu principal --}}
    <div class="flex-1">

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-sm text-gray-400">
                    <a href="{{ route('dashboard') }}" class="hover:text-blue-500">{{ __('Articles') }}</a>
                    <span class="mx-2">›</span>
                    <span class="text-blue-500">{{ __('Nouvel Article') }}</span>
                </p>
                <h1 class="text-2xl font-bold text-gray-800">{{ __('Éditeur de Publication') }}</h1>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="setStatut('brouillon')"
                    class="bg-gray-100 text-gray-700 px-5 py-2 rounded-lg font-semibold hover:bg-gray-200">
                    {{ __('Enregistrer') }}
                </button>
                <button type="button" onclick="setStatut('publie')"
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

        <form id="form-article" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="statut" id="statut-input" value="en_attente">

            <div class="flex gap-6">

                {{-- Éditeur --}}
                <div class="flex-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">

                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-3">{{ __("Titre de l'article") }}</label>
                        <input type="text" name="titre" id="titre"
                            placeholder="Entrez un titre captivant..."
                            value="{{ old('titre') }}"
                            class="w-full text-2xl font-bold text-gray-700 placeholder-gray-300 border-0 focus:outline-none focus:ring-0 mb-4">
                        <hr class="border-gray-100 mb-4">

                        {{-- Toolbar --}}
                        <div class="flex gap-2 mb-4 pb-4 border-b border-gray-100 flex-wrap">
                            <button type="button" onclick="format('bold')"
                                title="Gras"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded font-bold text-gray-600 hover:bg-blue-100 hover:text-blue-600">{{ __('B') }}</button>
                            <button type="button" onclick="format('italic')"
                                title="Italique"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded italic text-gray-600 hover:bg-blue-100 hover:text-blue-600">{{ __('I') }}</button>
                            <button type="button" onclick="insertTag('h1')"
                                title="Titre H1"
                                class="px-2 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600 font-bold text-sm">{{ __('H1') }}</button>
                            <button type="button" onclick="insertTag('h2')"
                                title="Titre H2"
                                class="px-2 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600 font-bold text-sm">{{ __('H2') }}</button>
                            <button type="button" onclick="insertTag('ul')"
                                title="Liste"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600 text-lg">≡</button>
                            <button type="button" onclick="insertQuote()"
                                title="Citation"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600 font-serif text-lg">"</button>
                            <button type="button" onclick="insertLink()"
                                title="Lien"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600">🔗</button>
                            <button type="button" onclick="insertImage()"
                                title="Image"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600">🖼️</button>
                            <div class="flex-1"></div>
                            <button type="button" onclick="undo()"
                                title="Annuler"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600">↩</button>
                            <button type="button" onclick="redo()"
                                title="Rétablir"
                                class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded text-gray-600 hover:bg-blue-100 hover:text-blue-600">↪</button>
                        </div>

                        <textarea name="contenu" id="contenu" rows="16"
                            placeholder="Commencez à raconter votre histoire..."
                            class="w-full border-0 focus:outline-none focus:ring-0 text-gray-700 resize-none leading-relaxed">{{ old('contenu') }}</textarea>
                    </div>
                </div>

                {{-- Panneau latéral --}}
                <div class="w-64 shrink-0">

                    {{-- Statut + Catégorie + Tags --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">

                        {{-- Statut toggle --}}
                        <div class="flex justify-between items-center mb-5">
                            <label class="text-xs text-gray-400 uppercase font-semibold">{{ __('Statut') }}</label>
                            <div class="flex items-center gap-2 cursor-pointer" onclick="toggleStatut()">
                                <span class="text-sm" id="label-brouillon">{{ __('Brouillon') }}</span>
                                <div id="toggle-btn" class="w-10 h-5 bg-gray-300 rounded-full relative transition-colors duration-200">
                                    <div id="toggle-circle" class="w-4 h-4 bg-white rounded-full absolute left-0.5 top-0.5 transition-all duration-200 shadow"></div>
                                </div>
                                <span class="text-sm text-gray-400" id="label-publie">{{ __('Publié') }}</span>
                            </div>
                        </div>

                        {{-- Catégorie --}}
                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-2">{{ __('Catégorie') }}</label>
                        <select name="category_id"
                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-5">
                            <option value="">{{ __('Choisir une catégorie') }}</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Tags --}}
                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-2">{{ __('Tags') }}</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label id="tag-label-{{ $tag->id }}"
                                    class="flex items-center gap-1 bg-gray-100 px-3 py-1 rounded-full cursor-pointer hover:bg-blue-100 transition-colors">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                        class="hidden"
                                        onchange="updateTagStyle({{ $tag->id }})"
                                        {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                    <span class="text-sm text-gray-600" id="tag-text-{{ $tag->id }}">{{ $tag->nom }}</span>
                                    <span class="text-gray-400 text-xs" id="tag-x-{{ $tag->id }}">+</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Image de couverture --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-4">
                        <label class="block text-xs text-gray-400 uppercase font-semibold mb-3">{{ __('Image de couverture') }}</label>
                        <label class="border-2 border-dashed border-gray-200 rounded-xl p-6 flex flex-col items-center justify-center cursor-pointer hover:border-blue-400 transition-colors">
                            <span class="text-3xl mb-2">☁️</span>
                            <span class="text-gray-600 font-semibold text-sm" id="upload-text">{{ __('Cliquer pour uploader') }}</span>
                            <span class="text-gray-400 text-xs mt-1">{{ __('PNG, JPG ou WEBP (Max. 5MB)') }}</span>
                            <input type="file" name="image" id="image-input" class="hidden" accept="image/*" onchange="previewImage(event)">
                        </label>
                        <img id="image-preview" src="" class="hidden w-full h-32 object-cover rounded-lg mt-3">
                    </div>

                    {{-- Aperçu Google --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="text-blue-500">🔵</span>
                            <p class="text-sm font-semibold text-gray-700">{{ __('Aperçu Google') }}</p>
                        </div>
                        <p class="text-blue-600 font-semibold text-sm mb-1" id="seo-titre">{{ __('Mon nouvel article passionnan...') }}</p>
                        <p class="text-green-600 text-xs mb-1">bloghub.com/{{ __('Articles') }}/mon-nouvel-article...</p>
                        <p class="text-gray-500 text-xs">{{ __('Le résumé de votre article apparaîtra ici pour attirer les lecteurs depuis les moteurs de...') }}</p>
                        <button type="button" class="text-blue-500 text-xs mt-2 hover:underline">{{ __('Modifier les métadonnées SEO') }}</button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Toggle statut
    let estPublie = false;

    function toggleStatut() {
        estPublie = !estPublie;
        const btn = document.getElementById('toggle-btn');
        const circle = document.getElementById('toggle-circle');
        const labelPublie = document.getElementById('label-publie');
        const labelBrouillon = document.getElementById('label-brouillon');
        const input = document.getElementById('statut-input');

        if (estPublie) {
            btn.classList.remove('bg-gray-300');
            btn.classList.add('bg-blue-500');
            circle.style.left = '1.25rem';
            labelPublie.classList.add('font-semibold', 'text-gray-700');
            labelPublie.classList.remove('text-gray-400');
            labelBrouillon.classList.remove('font-semibold');
            input.value = 'publie';
        } else {
            btn.classList.add('bg-gray-300');
            btn.classList.remove('bg-blue-500');
            circle.style.left = '0.125rem';
            labelBrouillon.classList.add('font-semibold');
            labelPublie.classList.remove('font-semibold', 'text-gray-700');
            labelPublie.classList.add('text-gray-400');
            input.value = 'brouillon';
        }
    }

    function setStatut(valeur) {
        document.getElementById('statut-input').value = valeur;
        document.getElementById('form-article').submit();
    }

    // Aperçu SEO en temps réel
    document.getElementById('titre').addEventListener('input', function() {
        const titre = this.value || @json(__("Mon nouvel article passionnan..."));
        document.getElementById('seo-titre').textContent = titre.substring(0, 50) + (titre.length > 50 ? '...' : '');
    });

    // Toolbar
    function format(cmd) {
        const textarea = document.getElementById('contenu');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const selected = textarea.value.substring(start, end);
        let result = '';

        if (cmd === 'bold') result = `**${selected || 'texte en gras'}**`;
        if (cmd === 'italic') result = `*${selected || 'texte en italique'}*`;

        textarea.value = textarea.value.substring(0, start) + result + textarea.value.substring(end);
        textarea.focus();
    }

    function insertTag(tag) {
        const textarea = document.getElementById('contenu');
        const start = textarea.selectionStart;
        const selected = textarea.value.substring(start, textarea.selectionEnd) || @json(__("Titre"));
        let result = '';

        if (tag === 'h1') result = `\n# ${selected}\n`;
        if (tag === 'h2') result = `\n## ${selected}\n`;
        if (tag === 'ul') result = `\n- ${selected}\n- Element 2\n- Element 3\n`;

        textarea.value = textarea.value.substring(0, start) + result + textarea.value.substring(textarea.selectionEnd);
        textarea.focus();
    }

    function insertQuote() {
        const textarea = document.getElementById('contenu');
        const start = textarea.selectionStart;
        const selected = textarea.value.substring(start, textarea.selectionEnd) || @json(__("Votre citation ici"));
        const result = `\n> ${selected}\n`;
        textarea.value = textarea.value.substring(0, start) + result + textarea.value.substring(textarea.selectionEnd);
        textarea.focus();
    }

    function insertLink() {
        const url = prompt( @json(__("Entrez l'URL du lien :")));
        if (url) {
            const textarea = document.getElementById('contenu');
            const start = textarea.selectionStart;
            const selected = textarea.value.substring(start, textarea.selectionEnd) || 'texte du lien';
            const result = `[${selected}](${url})`;
            textarea.value = textarea.value.substring(0, start) + result + textarea.value.substring(textarea.selectionEnd);
            textarea.focus();
        }
    }

    function insertImage() {
        const url = prompt( @json(__("Entrez l'URL de l'image :")));
        if (url) {
            const textarea = document.getElementById('contenu');
            const start = textarea.selectionStart;
            const result = `\n![Image](${url})\n`;
            textarea.value = textarea.value.substring(0, start) + result + textarea.value.substring(textarea.selectionEnd);
            textarea.focus();
        }
    }

    let history = [];
    let historyIndex = -1;

    function undo() {
        const textarea = document.getElementById('contenu');
        document.execCommand('undo');
    }

    function redo() {
        document.execCommand('redo');
    }

    // Tags style
    function updateTagStyle(id) {
        const checkbox = document.querySelector(`#tag-label-${id} input`);
        const label = document.getElementById(`tag-label-${id}`);
        const text = document.getElementById(`tag-text-${id}`);
        const x = document.getElementById(`tag-x-${id}`);

        if (checkbox.checked) {
            label.classList.remove('bg-gray-100');
            label.classList.add('bg-blue-100');
            text.classList.remove('text-gray-600');
            text.classList.add('text-blue-600', 'font-semibold');
            x.textContent = '×';
        } else {
            label.classList.add('bg-gray-100');
            label.classList.remove('bg-blue-100');
            text.classList.add('text-gray-600');
            text.classList.remove('text-blue-600', 'font-semibold');
            x.textContent = '+';
        }
    }

    // Preview image
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const preview = document.getElementById('image-preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                document.getElementById('upload-text').textContent = file.name;
            };
            reader.readAsDataURL(file);
        }
    }

    // Init tags déjà cochés
    document.querySelectorAll('.tag-checkbox').forEach(cb => {
        if (cb.checked) {
            const id = cb.value;
            updateTagStyle(id);
        }
    });
</script>

@endsection