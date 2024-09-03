
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"> --}}
@vite('resources/css/app.css')

        <div class="container mx-auto mt-5">
            <h1 class="text-2xl font-bold">Ajouter une Unité de Valeur</h1>

            <form action="{{ route('uniteValeur.store') }}" method="POST" class="space-y-6 bg-white p-6 rounded-lg shadow-blue-950 shadow-xl border-t-2 border-slate-500">
                @csrf

                <!-- Code -->
                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700">Code</label>
                    <input type="text" name="code" id="code" required placeholder="PAN112"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('code') }}">
                </div>

                <!-- Nom -->
                <div class="mb-4">
                    <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                    <input type="text" name="nom" id="nom" required placeholder="Mathematique"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('nom') }}">
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" placeholder="(facultatif) les mathematiques pour la filiere production animale et vegetal"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">{{ old('description') }}</textarea>
                </div>

                <!-- Crédit -->
                <div class="mb-4">
                    <label for="credit" class="block text-sm font-medium text-gray-700">Crédit</label>
                    <input type="number" name="credit" id="credit" required placeholder="2"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        value="{{ old('credit') }}">
                </div>

                <!-- Enseignant -->
                <div class="mb-4">
                    <label for="enseignant_id" class="block text-sm font-medium text-gray-700">Enseignant</label>
                    <select name="enseignant_id" id="enseignantModal" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Sélectionnez un enseignant --</option>
                        @foreach($enseignants as $enseignant)
                            <option value="{{ $enseignant->id }}" {{ old('enseignant_id') == $enseignant->id ? 'selected' : '' }}>
                                {{ $enseignant->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                   <!-- Niveau -->
                   <div class="mb-4">
                    <label for="niveau_id" class="block text-sm font-medium text-gray-700">Niveau</label>
                    <select name="niveau_id" id="niveauModal" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Sélectionnez un niveau --</option>
                        @foreach($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ old('niveau_id') == $niveau->id ? 'selected' : '' }}>
                                {{ $niveau->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                 

                <!-- Semestre -->
                <div class="mb-4">
                    <label for="semestre_id" class="block text-sm font-medium text-gray-700">Semestre</label>
                    <select name="semestre_id" id="semestreModal" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Sélectionnez un semestre --</option>
                        @foreach($semestres as $semestre)
                            <option value="{{ $semestre->id }}" {{ old('semestre_id') == $semestre->id ? 'selected' : '' }}>
                                {{ $semestre->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filière -->
                <div class="mb-4">
                    <label for="filiere_id" class="block text-sm font-medium text-gray-700">Filière</label>
                    <select name="filiere_id" id="filiereModal" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Sélectionnez une filière --</option>
                        @foreach($filieres as $filiere)
                            <option value="{{ $filiere->id }}" {{ old('filiere_id') == $filiere->id ? 'selected' : '' }}>
                                {{ $filiere->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Spécialité -->
                <div class="mb-4">
                    <label for="specialite_id" class="block text-sm font-medium text-gray-700">Spécialité</label>
                    <select name="specialite_id" id="specialiteModal" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Sélectionnez une spécialité --</option>
                        @foreach($specialites as $specialite)
                            <option value="{{ $specialite->id }}" {{ old('specialite_id') == $specialite->id ? 'selected' : '' }}>
                                {{ $specialite->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>

            
                <!-- Catégorie -->
                <div class="mb-4">
                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                    <select name="category_id" id="categoryModal" required
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-slate-900 shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">-- Sélectionnez une catégorie --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nom }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Bouton de soumission -->
                <div class="flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md shadow-slate-900 shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
        
    <script>
document.addEventListener("DOMContentLoaded", function () {

        const semestreSelect = document.getElementById("semestreModal");
        const niveauSelect = document.getElementById("niveauModal");
        const specialiteSelect = document.getElementById("specialiteModal");

   

        // Fonction pour mettre à jour les spécialités
        function updateSpecialites(niveauId) {
console.log(niveauId);

            fetch(`/specialites/${niveauId}`)
                .then(response => response.json())
                .then(data => {
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

        // Fonction pour mettre à jour les matières
  
        // Fonction pour mettre à jour les matières
      
        // Mise à jour des sélecteurs lors du chargement de la page
      
        if (niveauSelect.value) {
            updateSpecialites(niveauSelect.value);
        }
    

        // Ajouter les event listeners pour les changements dynamiques après sélection
        niveauSelect.addEventListener("input", function () {

            updateSpecialites(this.value);
        });

        });
    </script>

