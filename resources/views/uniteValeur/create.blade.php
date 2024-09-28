{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> --}}
@vite('resources/css/app.css')

<div class="container mx-auto mt-5">
    <div class="font-bold flex justify-between">
        <h1 class="text-2xl font-bold">Ajouter une Unité de Valeur</h1>
        <form method='post' action="{{ route('annee.setActive') }}" id="formAnnee">
            @csrf
            <label for="annee">Année Académique</label>
            <select name="annee" id="annee"
                class="border-none outline-none focus:border-none cursor-pointer" onchange="submit()">
                @foreach ($annees as $annee)
                    <option value="{{ $annee->id }}"
                        class="cursor-pointer border-b-4 border-double border-black"
                        {{ $annee->is_active == true ? 'selected' : '' }}>{{ $annee->nom }}</option>
                @endforeach
            </select>
        </form>
    </div>
    
    <form action="{{ route('uniteValeur.store') }}" method="POST" class="space-y-6  p-6 rounded-lg shadow-blue-950 shadow-xl border-t-2 border-slate-500 bg-gray-400">
        @csrf

        <!-- Code -->
        <div class="mb-4">
            <x-input-label for="code" :value="__('Code')" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" :value="old('code')" required placeholder="PAN112"/>
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <!-- Nom -->
        <div class="mb-4">
            <x-input-label for="nom" :value="__('Nom')" />
            <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required placeholder="Mathématiques"/>
            <x-input-error :messages="$errors->get('nom')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mb-4">
            <x-input-label for="description" :value="__('Description')" />
            <textarea id="description" name="description" class="block w-full px-3 py-2 mt-1 border rounded-md shadow-slate-900 shadow-md" placeholder="Description de l'UV">{{ old('description') }}</textarea>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Crédit -->
        <div class="mb-4">
            <x-input-label for="credit" :value="__('Crédit')" />
            <x-text-input id="credit" class="block mt-1 w-full" type="number" name="credit" :value="old('credit')" required placeholder="2"/>
            <x-input-error :messages="$errors->get('credit')" class="mt-2" />
        </div>

        <!-- Niveau -->
        <div class="mb-4">
            <x-input-label for="niveau_id" :value="__('Niveau')" />
            <select id="niveauModal" name="niveau_id" class="block mt-1 w-full" required>
                <option value="">-- Sélectionnez un niveau --</option>
                @foreach($niveaux as $niveau)
                    <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                        {{ $niveau->nom }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('niveau_id')" class="mt-2" />
        </div>

        
        <!-- Filière -->
        <div class="mb-4">
            <x-input-label for="filiere_id" :value="__('Filière')" />
            <select id="filiereModal" name="filiere_id" class="block mt-1 w-full" required>
                <option value="">-- Sélectionnez une filière --</option>
                @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                        {{ $filiere->nom }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('filiere_id')" class="mt-2" />
        </div>

        <!-- Spécialité -->
        <div class="mb-4">
            <x-input-label for="specialite_id" :value="__('Spécialité')" />
            <select id="specialiteModal" name="specialite_id" class="block mt-1 w-full" required>
                <option value="">-- Sélectionnez une spécialité --</option>
                @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                        {{ $specialite->nom }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('specialite_id')" class="mt-2" />
        </div>

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

        <!-- Bouton de soumission -->
        <div class="flex justify-end">
            <x-primary-button class="ml-3">
                {{ __('Enregistrer') }}
            </x-primary-button>
        </div>
    </form>
</div>

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
                // Déclencher l'événement input pour mettre à jour les matières
                const event = new Event('input', { bubbles: true });
                filiereSelect.dispatchEvent(event);
            });
    }

    // Mise à jour des spécialités lors du chargement de la page si un niveau et une filière sont déjà sélectionnés
    if (niveauSelect.value && filiereSelect.value) {
        updateSpecialites(niveauSelect.value, filiereSelect.value);
    }

    // Ajouter les event listeners pour mettre à jour dynamiquement les spécialités après sélection du niveau ou de la filière
    niveauSelect.addEventListener("input", function () {
        if (filiereSelect.value) {
            updateSpecialites(this.value, filiereSelect.value);
        }
        updateFilieres(this.value);

    });

    filiereSelect.addEventListener("input", function () {
        if (niveauSelect.value) {
            updateSpecialites(niveauSelect.value, this.value);
        }
    });

});

</script>
