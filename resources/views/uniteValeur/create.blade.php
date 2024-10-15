<x-layout>
    @section('title', 'Students')

    @section('content')
        <x-header />
        <x-menu />

        <div class="container mx-auto mt-2 bg-slate-500 py-4 rounded-md">
            <div class="font-bold flex justify-between">
                <h1 class="text-2xl font-bold">Ajouter une Unité de Valeur</h1>
                <form method='post' action="{{ route('annee.setActive') }}" id="formAnnee">
                    @csrf
                    <label for="annee">Année Académique</label>
                    <select name="annee" id="annee" class="border-none outline-none focus:border-none cursor-pointer" onchange="submit()">
                        @foreach ($annees as $annee)
                            <option value="{{ $annee->id }}" class="cursor-pointer border-b-4 border-double border-black" {{ $annee->is_active == true ? 'selected' : '' }}>
                                {{ $annee->nom }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <form action="{{ route('uniteValeur.store') }}" method="POST" class="space-y-6 p-6 rounded-lg shadow-blue-950 shadow-xl border-t-2 border-slate-500 ">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <!-- Nom -->
                    <div class="mb-4">
                        <x-input-label for="nom" :value="__('Nom')" />
                        <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required placeholder="Mathématiques" />
                        <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                    </div>

                    <!-- Crédit -->
                    <div class="mb-4">
                        <x-input-label for="credit" :value="__('Crédit')" />
                        <x-text-input id="credit" class="block mt-1 w-full" type="number" name="credit" :value="old('credit')" required placeholder="2" />
                        <x-input-error :messages="$errors->get('credit')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="mb-4 col-span-1 md:col-span-2">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description" class="block w-full px-3 py-2 mt-1 border rounded-md shadow-slate-900 shadow-md" placeholder="Description de l'UV">{{ old('description') }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">


                    <!-- Semestre -->
                    <div class="mb-4">
                        <x-input-label for="semestre_id" :value="__('Semestre')" />
                        <select id="semestreModal" name="semestre_id" class="block mt-1 w-full" required>
                            <option value="">-- Sélectionnez un semestre --</option>
                            @foreach($semestres as $semestre)
                                <option value="{{ $semestre->id }}" {{ old('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                    {{ $semestre->nom }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('semestre_id')" class="mt-2" />
                    </div>

                    <!-- Catégorie -->
                    <div class="mb-4">
                        <x-input-label for="category_id" :value="__('Catégorie')" />
                        <select id="categoryModal" name="category_id" class="block mt-1 w-full" required>
                            <option value="">-- Sélectionnez une catégorie --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nom }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                </div>

                <!-- Bouton de soumission -->
                <div class="flex justify-end">
                    <button class="ml-3 bg-blue-500 rounded-lg p-3 px-4 text-white font-bold text-1xl">
                        {{ __('Enregistrer') }}
                    </button>
                </div>
            </form>
        </div>
    @endsection
    </x-layout>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const semestreSelect = document.getElementById("semestreModal");
        const niveauSelect = document.getElementById("niveauModal");
        const filiereSelect = document.getElementById("filiereModal");
        const specialiteSelect = document.getElementById("specialiteModal");

        // Fonction pour mettre à jour les spécialités en fonction du niveau et de la filière
        function updateSpecialites(niveauId, filiereId) {
            fetch(`/specialites/${niveauId}/${filiereId}`)
            .then(response => response.json())
            .then(data => {
                console.log(`Niveau ID: ${niveauId}, Filière ID: ${filiereId}`);
                specialiteSelect.innerHTML = ""; // Clear previous options
                data.forEach(specialite => {
                    let option = document.createElement("option");
                    option.value = specialite.id;
                    option.textContent = specialite.nom;
                    specialiteSelect.appendChild(option);
                });
                // Déclencher l'événement input pour mettre à jour les matières
                const event = new Event('input', { bubbles: true });
                specialiteSelect.dispatchEvent(event);
            });
        }

        function updateFilieres(niveauId) {
            console.log(`Niveau ID: ${niveauId}`);

            fetch(`/filieres/${niveauId}`)
            .then(response => response.json())
            .then(data => {
                filiereSelect.innerHTML = ""; // Clear previous options
                data.forEach(filiere => {
                    let option = document.createElement("option");
                    option.value = filiere.id;
                    option.textContent = filiere.nom;
                    filiereSelect.appendChild(option);
                });
                // Déclencher l'événement input pour mettre à jour les spécialités
                const event = new Event('input', { bubbles: true });
                filiereSelect.dispatchEvent(event);
            });
        }

        niveauSelect.addEventListener("change", function () {
            const niveauId = this.value;
            updateFilieres(niveauId);
        });

        filiereSelect.addEventListener("change", function () {
            const filiereId = this.value;
            const niveauId = niveauSelect.value;
            updateSpecialites(niveauId, filiereId);
        });
    });
    </script>
