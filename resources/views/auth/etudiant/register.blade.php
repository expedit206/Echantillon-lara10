<x-layout>
    @section('title', 'Students')

    @section('content')
        <x-header />
        <x-menu />
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class=" mx-auto p-6 bg-slate-500 rounded-lg shadow-md mt-10">
            <div class="flex justify-between mb-6">
                <h1 class="text-2xl font-bold">Inscription Étudiant</h1>
                <form method='post' action="{{route('annee.setActive')}}" id="formAnnee">
                    @csrf
                    <label for="annee" class="italic">Année Académique</label>
                    <select name="annee" id="annee" class="rounded-full bg-slate-400 border-none outline-none focus:border-none cursor-pointer" onchange="submit()">
                        @foreach($annees as $annee)
                            <option value="{{ $annee->id }}" class="cursor-pointer border-b-4 border-double border-black"
                                {{ $annee->is_active ? 'selected' : '' }}>
                                {{ $annee->nom }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <form method="POST" action="{{ route('etudiant.register') }}" class="space-y-6 p-6 rounded-lg shadow-blue-950 shadow-xl border-t-2 border-slate-500 " enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <x-label for="nom" value="{{ __('Nom') }}" />
                        <x-input id="nom" name='nom' class="block mt-1 w-full border border-gray-300 rounded-md p-2" type="text"  :value="old('nom')" autofocus autocomplete="nom" />
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
                        <x-label for="lieuNaiss" value="{{ __('Lieu de naissance') }}" />
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
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit" class="ms-4 inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let matiereSelect = document.getElementById('matiere_id');
                let filiereSelect = document.getElementById('filiere_id');
                let specialiteSelect = document.getElementById('specialite_id');
                let niveauSelect = document.getElementById('niveau_id');

                // Fonction pour remplir les filières
                function loadFilieres(niveauId, callback) {
                    fetch(`/filieres/${niveauId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            filiereSelect.innerHTML = '';
                            data.forEach(filiere => {
                                filiereSelect.innerHTML += `<option value="${filiere.id}">${filiere.nom}</option>`;
                            });

                            // Appel du callback après que les filières sont chargées
                            if (callback) {
                                callback();
                            }
                        });
                }

                // Fonction pour remplir les spécialités
                function loadSpecialites(niveauId, filiereId, callback) {
                    fetch(`/specialites/${niveauId}/${filiereId}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            specialiteSelect.innerHTML = '';
                            data.forEach(specialite => {
                                specialiteSelect.innerHTML += `<option value="${specialite.id}">${specialite.nom}</option>`;
                            });

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
                            matiereSelect.innerHTML = '';
                            console.log(data);
                            data.forEach(matiere => {
                                matiereSelect.innerHTML += `<option value="${matiere.id}">${matiere.nom}</option>`;
                            });
                        });
                }

                // Événements de changement pour niveau, filière, spécialité
                niveauSelect.addEventListener('change', function () {
                    let niveauId = this.value;
                    loadFilieres(niveauId);
                });

                filiereSelect.addEventListener('input', function () {
                    let niveauId = niveauSelect.value;
                    let filiereId = this.value;
                    if (niveauId && filiereId) {
                        loadSpecialites(niveauId, filiereId);
                    }
                });

                specialiteSelect.addEventListener('input', function () {
                    let niveauId = niveauSelect.value;
                    let filiereId = filiereSelect.value;
                    let specialiteId = this.value;
                    if (niveauId && filiereId && specialiteId) {
                        loadMatieres(niveauId, filiereId, specialiteId);
                    }
                });

                // Chargement initial des données au chargement de la page
                if (niveauSelect.value) {
                    loadFilieres(niveauSelect.value, function () {
                        if (filiereSelect.value) {
                            loadSpecialites(niveauSelect.value, filiereSelect.value);
                        }
                    });
                }

                if (filiereSelect.value && niveauSelect.value) {
                    loadSpecialites(niveauSelect.value, filiereSelect.value);
                }

                if (specialiteSelect.value && filiereSelect.value && niveauSelect.value) {
                    loadMatieres(niveauSelect.value, filiereSelect.value, specialiteSelect.value);
                }
            });
            </script>

    @endsection
</x-layout>
