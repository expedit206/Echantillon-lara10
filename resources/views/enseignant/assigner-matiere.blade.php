<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Assigner une matière à un enseignant') }}
        </h2>
    </x-slot>
{{-- @dd($niveaux) --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    @if (session('success'))
                        <div class="bg-green-500 text-white p-4 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('assigner-matiere.store') }}">
                        @csrf

                        <!-- Sélection de l'enseignant -->
                        <div>
                            <x-label for="enseignant_id" :value="__('Enseignant')" />
                            <select name="enseignant_id" id="enseignant_id" class="block mt-1 w-full">
                                @foreach($enseignants as $enseignant)
                                    <option value="{{ $enseignant->id }}">{{ $enseignant->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sélection du niveau -->
                        <div class="mt-4">
                            <x-label for="niveau_id" :value="__('Niveau')" />
                            <select name="niveau_id" id="niveau_id" class="block mt-1 w-full">
                                @foreach($niveaux as $niveau)
                                    <option value="{{ $niveau->id }}"> {{ $niveau->nom }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sélection de la filière (dynamique selon le niveau) -->
                        <div class="mt-4">
                            <x-label for="filiere_id" :value="__('Filière')" />
                            <select name="filiere_id" id="filiere_id" class="block mt-1 w-full">
                                <!-- Options dynamiques selon le niveau sélectionné -->
                                @foreach($filieres as $filiere)
                                <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                            @endforeach
                            </select>
                        </div>

                        <!-- Sélection de la spécialité (dynamique selon la filière) -->
                        <div class="mt-4">
                            <x-label for="specialite_id" :value="__('Spécialité')" />
                            <select name="specialite_id" id="specialite_id" class="block mt-1 w-full">
                                <!-- Options dynamiques selon la filière sélectionnée -->
                                @foreach($specialites as $specialite)
                                <option value="{{ $specialite->id }}">{{ $specialite->nom }}</option>
                            @endforeach
                            </select>
                        </div>

                        <!-- Sélection de la matière (dynamique selon la spécialité) -->
                        <div class="mt-4">
                            @dump($uniteValeurs)
                            <x-label for="matiere_id" :value="__('Matière')" />
                            <select name="matiere_id" id="matiere_id" class="block mt-1 w-full">
                                <!-- Options dynamiques selon la spécialité sélectionnée -->
                                @foreach($uniteValeurs as $unite_de_valeurs)
                                <option value="{{ $unite_de_valeurs->id }}">{{ $unite_de_valeurs->nom }}</option>
                            @endforeach
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button>
                                {{ __('Assigner la matière') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- <script>
        document.getElementById('niveau_id').addEventListener('change', function () {
            let niveauId = this.value;

            fetch('/filieres-par-niveau/' + niveauId)
                .then(response => response.json())
                .then(data => {
                    let filiereSelect = document.getElementById('filiere_id');
                    filiereSelect.innerHTML = '';
                    data.filieres.forEach(filiere => {
                        filiereSelect.innerHTML += `<option value="${filiere.id}">${filiere.nom}</option>`;
                    });
                });
        });

        document.getElementById('filiere_id').addEventListener('change', function () {
            let filiereId = this.value;

            fetch('/specialites-par-filiere/' + filiereId)
                .then(response => response.json())
                .then(data => {
                    let specialiteSelect = document.getElementById('specialite_id');
                    specialiteSelect.innerHTML = '';
                    data.specialites.forEach(specialite => {
                        specialiteSelect.innerHTML += `<option value="${specialite.id}">${specialite.nom}</option>`;
                    });
                });
        });

        document.getElementById('specialite_id').addEventListener('change', function () {
            let specialiteId = this.value;

            fetch('/matieres-par-specialite/' + specialiteId)
                .then(response => response.json())
                .then(data => {
                    let matiereSelect = document.getElementById('matiere_id');
                    matiereSelect.innerHTML = '';
                    data.matieres.forEach(matiere => {
                        matiereSelect.innerHTML += `<option value="${matiere.id}">${matiere.nom}</option>`;
                    });
                });
        });
    </script> --}}

</x-app-layout>
