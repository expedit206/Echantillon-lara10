<x-layout>
    @section('title', 'Assigner une Matière à un Enseignant')
{{-- @dd($matieres) --}}
    @section('content')
    <x-header />
    <x-menu />

    <div class="container mx-auto p-6 bg-slate-400">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Assigner une Matière à un Enseignant</h1>

        {{-- @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif --}}

        <form method="POST" action="{{ route('assigner-matiere.store') }}">
            @csrf

            <!-- Sélection de l'enseignant -->
            <div class="mb-4">
                <p>* Choisir l'enseignant</p>
                <x-label class="text-gray-800" for="enseignant_id" :value="__('Enseignant')" />
                <select name="enseignant_id" id="enseignant_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                    @foreach($enseignants as $enseignant)
                        <option value="{{ $enseignant->id }}">{{ $enseignant->nom }}</option>
                    @endforeach
                </select>
            </div>

           <p>* Choisir l'unite de valeur </p>

            <!-- Sélection du niveau -->
            <div class="mb-4">
                <x-label class="text-gray-800" for="niveau_id" :value="__('Niveau')" />
                <select name="niveau_id" id="niveau_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50">
                    @foreach($niveaux as $niveau)
                        <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Sélection de la filière -->
            <div class="mb-4">
                <x-label class="text-gray-800" for="filiere_id" :value="__('Filière')" />
                <select name="filiere_id" id="filiere_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"></select>
            </div>

            <!-- Sélection de la spécialité -->
            <div class="mb-4">
                <x-label class="text-gray-800" for="specialite_id" :value="__('Spécialité')" />
                <select name="specialite_id" id="specialite_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"></select>
            </div>

            <!-- Sélection de la matière -->
            <div class="mb-4">
                <x-label class="text-gray-800" for="matiere_id" :value="__('Matière')" />
                <select name="matiere_id" id="matiere_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"></select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md shadow hover:bg-blue-600 focus:outline-none focus:ring focus:ring-blue-300">
                    {{ __('Assigner la matière') }}
                </button>
            </div>
        </form>
    </div>
    <script>
        // Fonction pour remplir les filières
        function loadFilieres(niveauId, callback) {
            fetch(`/filieres/${niveauId}`)
                .then(response => response.json())
                .then(data => {
                    let filiereSelect = document.getElementById('filiere_id');
                    filiereSelect.innerHTML = '';
                    data.forEach(filiere => {
                        filiereSelect.innerHTML += `<option value="${filiere.id}">${filiere.nom}</option>`;
                    });

                    // Appel du callback après que les filières sont chargées
                    if (callback) {
                        callback();
                    }

                    document.getElementById('specialite_id').innerHTML = '';
                    document.getElementById('matiere_id').innerHTML = '';
                });
        }

        // Fonction pour remplir les spécialités
        function loadSpecialites(niveauId, filiereId, callback) {
            fetch(`/specialites/${niveauId}/${filiereId}`)
                .then(response => response.json())
                .then(data => {
                    let specialiteSelect = document.getElementById('specialite_id');
                    specialiteSelect.innerHTML = '';
                    data.forEach(specialite => {
                        specialiteSelect.innerHTML += `<option value="${specialite.id}">${specialite.nom}</option>`;
                    });
                    document.getElementById('matiere_id').innerHTML = '';

                    // Appel du callback après que les spécialités sont chargées
                    if (callback) {
                        callback();
                    }
                });
        }

        // Fonction pour remplir les matières
        function loadMatieres(niveauId, filiereId, specialiteId) {
            fetch(`/matieres/${niveauId}/${filiereId}/${specialiteId}`)
                .then(response => response.json())
                .then(data => {

                    let matiereSelect = document.getElementById('matiere_id');
                    matiereSelect.innerHTML = '';
                    console.log(data);
                    data.forEach(matiere => {
                        matiereSelect.innerHTML += `<option value="${matiere.id}">${matiere.nom}</option>`;
                    });
                });
        }

        // Événements de changement pour niveau, filière, spécialité
        document.getElementById('niveau_id').addEventListener('change', function () {
            let niveauId = this.value;
            loadFilieres(niveauId);
        });

        document.getElementById('filiere_id').addEventListener('input', function () {
            let niveauId = document.getElementById('niveau_id').value;
            let filiereId = this.value;
            if (niveauId && filiereId) {
                loadSpecialites(niveauId, filiereId, function() {
                    let specialiteId = document.getElementById('specialite_id').value;
                    if (specialiteId) {
                        loadMatieres(niveauId, filiereId, specialiteId);
                    }
                });
            }
        });

        document.getElementById('specialite_id').addEventListener('change', function () {
            let niveauId = document.getElementById('niveau_id').value;
            let filiereId = document.getElementById('filiere_id').value;
            let specialiteId = this.value;
            if (niveauId && filiereId && specialiteId) {
                loadMatieres(niveauId, filiereId, specialiteId);
            }
        });

        // Charger les options au chargement de la page si des valeurs sont déjà sélectionnées
        document.addEventListener('DOMContentLoaded', function () {
            let niveauId = document.getElementById('niveau_id').value;

            // Charger les filières si un niveau est déjà sélectionné
            if (niveauId) {
                loadFilieres(niveauId, function() {
                    let filiereId = document.getElementById('filiere_id').value;
                    // Charger les spécialités après les filières
                    if (filiereId) {
                        loadSpecialites(niveauId, filiereId, function() {
                            // Charger les matières après les spécialités
                            let specialiteId = document.getElementById('specialite_id').value;

                            if (specialiteId) {
                                // console.log('bj');
                                loadMatieres(niveauId, filiereId, specialiteId);
                            }
                        });
                    }
                });
            }
        });
    </script>

    @endsection
</x-layout>
