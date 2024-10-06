<x-layout>

    @section('title', 'Attribuer une note')

    @section('content')
        <x-header />
        <x-menu />

        <div class="filter">
            <div class="flex justify-between">

                @auth()
                    ->guard('admin')->user()

                    <a href="{{ route('uniteValeur.create') }}" class="btn text-violet-800 font-bold flex w-1/3">
                        Ajouter une unité de valeur
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px"
                            height="24px">
                            <path
                                d="M10.293 6.293L8.879 7.707 13.172 12 8.879 16.293l1.414 1.414L16 12zM14.293 6.293L12.879 7.707 17.172 12 12.879 16.293l1.414 1.414L20 12z" />
                        </svg>
                    </a>
                @endauth

                <div class="font-bold">
                    <form method='post' action="{{ route('annee.setActive') }}" id="formAnnee">
                        @csrf
                        <label for="annee">Année Académique</label>
                        <select name="annee" id="annee"
                            class="border-none outline-none focus:border-none cursor-pointer" onchange="submit()">
                            @foreach ($annees as $annee)
                                <option value="{{ $annee->id }}"
                                    class="cursor-pointer border-b-4 border-double border-black"
                                    {{ $annee->is_active == true ? 'selected' : '' }}>
                                    {{ $annee->nom }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
<!-- Section pour afficher les erreurs -->
@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Erreurs de validation :</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <!-- Filtre par paramètres -->
            <form method="get" action="{{ route('uniteValeur.index') }}" id="form"
                class="px-3 text-white grid-cols-5 content flex gap-3 items-center justify-around bg-orange-400 py-2">
                @csrf

                <h3>Filtrer par:</h3>

                <article class="flex flex-col w-full">
                    <label for="niveau">Niveau</label>
                    <select id="niveau" name="niveau" class="text-black rounded-md w-full" onchange="submit()">
                        <option value=""></option>
                        @foreach ($niveaux as $niveau)
                            <option value="{{ $niveau->id }}" {{ request('niveau') == $niveau->id ? 'selected' : '' }}>
                                {{ $niveau->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>

                <article class="flex flex-col w-full">
                    <label for="specialite">Spécialité</label>
                    <select id="specialite" name="specialite" class="text-black rounded-md w-full" onchange="submit()">
                        <option value=""></option>
                        @foreach ($specialites as $specialite)
                            <option value="{{ $specialite->id }}"
                                {{ request('specialite') == $specialite->id ? 'selected' : '' }}>
                                {{ $specialite->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>

                <article class="flex flex-col w-full">
                    <label for="semestre">Semestre</label>
                    <select id="semestre" name="semestre" class="text-black rounded-md w-full" onchange="submit()">
                        <option value=""></option>
                        @foreach ($semestres as $semestre)
                            <option value="{{ $semestre->id }}"
                                {{ request('semestre') == $semestre->id ? 'selected' : '' }}>
                                {{ $semestre->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>

                <article class="flex flex-col w-full">
                    <label for="unitevaleur">Unité de Valeur</label>
                    <select id="unitevaleur" name="unitevaleur" class="text-black rounded-md w-full" onchange="submit()">
                        <option value=""></option>
                        @foreach ($uniteValeurs as $unitevaleur)
                            <option value="{{ $unitevaleur->id }}"
                                {{ request('matieres') == $unitevaleur->id ? 'selected' : '' }}>
                                {{ $unitevaleur->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>
            </form>
        </div>

        <form method="post" action="{{ route('notes.store') }}" class="table mt-3">
            @csrf

            <input type="text" name="annee" value={{ request('annee') }} hidden>
            <input type="text" name="semestre" value={{ request('semestre') }} hidden>
            <input type="text" name="unite_valeur" value={{ request('matieres') }} hidden>

            <p>Total : {{ $totalEtudiant }}</p>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-1 border text-center">Matricule</th>
                        <th class="px-1 border text-center">Nom et prénom</th>
                        <th class="px-1 border text-center">Contrôle Continu</th>
                        <th class="px-1 border text-center">Session Normale</th>
                        <th class="px-1 border text-center">Rattrapage</th>
                        <th class="px-1 border text-center">Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($etudiants as $etudiant)

                  @php
                    $controleContinu = $etudiant->notes()->where('type', 'Controle continu')->first();
                    $sessionNormale = $etudiant->notes()->where('type', 'Normale')->first();
                    $rattrapage = $etudiant->notes()->where('type', 'Rattrapage')->first();

                    // Calcul de la moyenne avec 30% pour le contrôle continu et 70% pour la session normale
                    if ($rattrapage) {
                        // Si la note de rattrapage est présente, elle remplace la session normale avec un poids de 70%
                        $moyenne = ($controleContinu ? $controleContinu->note * 0.3 : 0) + ($rattrapage->note * 0.7);
                    } else {
                        // Sinon, on utilise la session normale pour le calcul
                        $moyenne = ($controleContinu ? $controleContinu->note * 0.3 : 0) + ($sessionNormale ? $sessionNormale->note * 0.7 : 0);
                    }
                @endphp

                        <tr>
                            <td class="px-1 border">{{ $etudiant->matricule }}</td>
                            <td class="px-1 border">{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>

                            <!-- Contrôle Continu -->
                            <td class="px-1 border">
                                <x-input type="text" name="notes[{{ $etudiant->id }}][controle_continu]"
                                    value="{{ $controleContinu ? $controleContinu->note : '' }}"
                                    placeholder="N/A" class="border-none bg-transparent" />
                            </td>

                            <!-- Session Normale -->
                            <td class="px-1 border">
                                <x-input type="text" name="notes[{{ $etudiant->id }}][session_normale]"
                                    value="{{ $sessionNormale ? $sessionNormale->note : '' }}"
                                    placeholder="N/A" class="border-none bg-transparent" />
                            </td>

                            <!-- Rattrapage -->
                            <td class="px-1 border">
                                <x-input type="text" name="notes[{{ $etudiant->id }}][rattrapage]"
                                    value="{{ $rattrapage ? $rattrapage->note : '' }}"
                                    placeholder="N/A" class="border-none bg-transparent" />
                            </td>

                            <!-- Moyenne -->
                            <td class="px-1 border">{{ number_format($moyenne, 2) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune note enregistrée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $etudiants->appends(request()->input())->links() }}
            <button type="submit" class="btn bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-2">
                Enregistrer
            </button>
        </form>


    @endsection
</x-layout>
