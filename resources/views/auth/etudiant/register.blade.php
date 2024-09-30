<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inscription Étudiant</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-900">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    

    <div class="max-w-3xl mx-auto p-6 bg-slate-500 rounded-lg shadow-md mt-10">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold mb-6">Inscription Étudiant</h1>
            <form method='post' action="{{route('annee.setActive')}}" id="formAnnee">
                @csrf
                        <label for="annee" class="italic">Année Académique</label>
                        <select name="annee" id="annee" class="rounded-full bg-slate-400 border-none outline-none focus:border-none cursor-pointer" onchange="submit()" 
                        >
                            @foreach($annees as $annee)
                            <option value="{{ $annee->id }}" class="cursor-pointer border-b-4 border-double border-black" 
                                {{ $annee->is_active==true? 'selected':''}}
                                >{{ $annee->nom }}</option>
                            @endforeach
                        </select>
                    </form>
        </div>
        <form method="POST" action="{{ route('etudiant.register') }}" enctype="multipart/form-data" class="">
            @csrf
            
            <div class="mb-4">
                <x-label for="nom" value="{{ __('Nom') }}" />
                <x-input id="nom" name='nom' class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text"  :value="old('nom')"  autofocus autocomplete="nom" />
            </div>

            <div class="mb-4">
                <x-label for="prenom" value="{{ __('Prénom') }}" />
                <x-input id="prenom" name="prenom" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text" :value="old('prenom')"  autocomplete="prenom" />
            </div>

            <div class="mb-4">
                <x-label for="dateNaissance" value="{{ __('Date de naissance') }}" />
                <x-input id="dateNaissance" name="dateNaissance" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="date" :value="old('dateNaissance')"  autocomplete="bday" />
            </div>

            <div class="mb-4">
                <x-label for="lieuNaiss" value="{{ __('lieuNaiss') }}" />
                <x-input id="lieuNaiss" name="lieuNaiss" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text" :value="old('lieuNaiss')"  autocomplete="lieuNaiss" />
            </div>

            <div class="mb-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" name="email" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="email" :value="old('email')"  autocomplete="email" />
            </div>

            <div class="mb-4">
                <x-label for="photo" value="{{ __('Photo') }}" />
                <input id="photo" name="photo" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="file" accept="image/*" />
            </div>

            <div class="mb-4">
                <x-label for="telephone" value="{{ __('Téléphone') }}" />
                <x-input id="telephone" name="numeroTelephone" class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="number" :value="old('telephone')"  />
            </div>

            <div class="mb-4">
                <x-label for="sexe" value="{{ __('Sexe') }}" />
                <select id="sexe" name="sexe" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    <option value="Masculin">Masculin</option>
                    <option value="Féminin">Féminin</option>
                    <option value="Autre">Autre</option>
                </select>
            </div>

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

            
            <div class="flex items-center justify-end mt-4">
                {{-- <button type='cancel' class="underline text-sm text-gray-800 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    {{ __('Already registered?') }}
                </button> --}}

                <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    {{ __('Register') }}
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
</body>
</html>
