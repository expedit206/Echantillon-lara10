<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    {{-- @yield('linkCss') --}}

    <link rel="stylesheet" href="/modal/modal.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">

    <link rel="stylesheet" href="/menuVertical/css/style.css">
    <link rel="stylesheet" href="/menuHorizontal/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite('resources/css/app.css')
</head>

<body id="body-pd" class="body-pd">
    @php

        $enseignant = \Auth::guard('enseignant')->user();
        // dd($enseignant);
        $annee_id = App\Models\Annee::where('is_active', true)->first()->id;

        if ($enseignant) {
            $niveaux = App\Models\Niveau::whereHas('enseignants', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
                ->whereRelation('uniteValeurs', 'annee_id', $annee_id)
                ->get();

            $specialites = App\Models\Specialite::whereHas('enseignants', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })
                ->whereRelation('uniteValeurs', 'annee_id', $annee_id)
                ->get();

            // dump($specialites);

            $uniteValeurs = App\Models\UniteValeur::whereHas('enseignant', function ($query) use ($enseignant) {
                $query->where('id', $enseignant->id);
            })
                ->whereRelation('annee', 'is_active', true)
                ->get();

            $semestres = App\Models\Semestre::whereHas('uniteValeurs', function ($query) use ($enseignant) {
                $query->where('enseignant_id', $enseignant->id);
            })->get();

            // ->whereRelation('uniteValeurs', 'annee_id', $annee_id);
        }

    @endphp
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0/dist/chartjs-plugin-datalabels.min.js">
    </script>
    <script src="/menuVertical/js/script.js"></script>
    <script src="/menuHorizontal/js/script.js"></script>
    <x-modal-form :annees="$annees" :semestres="$semestres" :niveaux="$niveaux" :specialites="$specialites" :matieres="$uniteValeurs" />

    <script src="/modal/modal.js"></script>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="/swiper.dash/swiper.js"></script>
</body>

</html>


{{-- Formulaire pour le choix des spécialités --}}
<div id="overlay" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden"></div>
<div id="selectionForm" style="display: none;" class="mt-4 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-lg font-semibold mb-4 text-gray-700">Sélectionner la Spécialité concernée</h2>
    <form action="{{ route('specialite.selectUnite') }}" method="GET">
        @csrf

        <div class="mb-4">
            <x-label for="niveau" :value="__('Niveau')" />
            <select id="niveau" name="niveau" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                <option value="">-- Choisir un Niveau --</option>
                @foreach($niveaux as $niveau)
                    <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <x-label for="specialite" :value="__('Spécialité')" />
            <select id="specialite" name="specialite" class="block mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
                <option value="">-- Choisir une Spécialité --</option>
                <!-- Les spécialités seront injectées ici via JavaScript -->
            </select>
        </div>

        <div class="mt-6">
            <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring focus:ring-blue-800">
                {{ __('Suivant') }}
            </button>
            <button type="button" id="cancelButton" class="ml-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring focus:ring-red-300">
                {{ __('Annuler') }}
            </button>
        </div>
    </form>
</div>


{{-- <a href="#" id="showFormLink" class="text-blue-500">Choisir une spécialité</a> --}}

<script>
    
    document.getElementById('showFormLink').addEventListener('click', function(event) {
        event.preventDefault(); // Empêche le rechargement de la page
        document.getElementById('selectionForm').style.display = 'block'; // Affiche le formulaire
        document.getElementById('overlay').style.display = 'block'; // Affiche l'overlay
    });

    document.getElementById('cancelButton').addEventListener('click', function() {
        document.getElementById('selectionForm').style.display = 'none';
        document.getElementById('overlay').style.display = 'none';
    });

    document.getElementById('niveau').addEventListener('change', function() {
        let niveauId = this.value;
        let specialiteSelect = document.getElementById('specialite');

        // Réinitialiser le select des spécialités
        specialiteSelect.innerHTML = '<option value="">-- Choisir une Spécialité --</option>';

        if (niveauId) {
            console.log(specialiteSelect);
            

            fetch(`/specialites/${niveauId}`)
            // .then(response => console.log(response.body.json))
            .then(response => response.json())
            .then(data => {
                specialiteSelect.innerHTML = ""; // Clear previous options

                    data.forEach(function(specialite) {
                        let option = document.createElement('option');
                        option.value = specialite.id;
                        option.textContent = specialite.nom;
                        specialiteSelect.appendChild(option);
                        console.log(specialiteSelect)
                    });
                });
        }
    });
</script>
