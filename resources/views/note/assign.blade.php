<x-layout>

    @section('title', 'Attribuer une note')

    @section('content')
        <x-header />
        <x-menu />

        <div class="filter">
            <div class="flex justify-between">
                <a href="{{ route('uniteValeur.create') }}" class="btn text-violet-800 font-bold flex w-1/3">
                    Ajouter une unité de valeur
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px">
                        <path d="M10.293 6.293L8.879 7.707 13.172 12 8.879 16.293l1.414 1.414L16 12zM14.293 6.293L12.879 7.707 17.172 12 12.879 16.293l1.414 1.414L20 12z" />
                    </svg>
                </a>

                <div class="font-bold">
                    <form method='post' action="{{ route('annee.setActive') }}" id="formAnnee">
                        @csrf
                        <label for="annee">Année Académique</label>
                        <select name="annee" id="annee" class="border-none outline-none focus:border-none cursor-pointer"
                            onchange="submit()">
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
                            <option value="{{ $specialite->id }}" {{ request('specialite') == $specialite->id ? 'selected' : '' }}>
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
                            <option value="{{ $semestre->id }}" {{ request('semestre') == $semestre->id ? 'selected' : '' }}>
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
                            <option value="{{ $unitevaleur->id }}" {{ request('matieres') == $unitevaleur->id ? 'selected' : '' }}>
                                {{ $unitevaleur->nom }}
                            </option>
                        @endforeach
                    </select>
                </article>
            </form>
        </div>

        <div class="table mt-3">
<p>Total : {{$totalEtudiant}}</p>
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border">Matricule</th>
                        <th class="py-2 px-4 border">Nom et prenom</th>
                        <th class="py-2 px-4 border">Contrôle Continu</th>
                        <th class="py-2 px-4 border">Session Normale</th>
                        <th class="py-2 px-4 border">Rattrapage</th>
                        <th class="py-2 px-4 border">Moyenne</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($etudiants as $etudiant)
                            @php
                                $controleContinu = $etudiant->notes()->where('type', 'Controle continu')->first();
                                $sessionNormale = $etudiant->notes()->where('type', 'Normale')->first();
                                $rattrapage = $etudiant->notes()->where('type', 'Rattrapage')->first();
                                $moyenne = ($controleContinu ? $controleContinu->note : 0) + ($sessionNormale ? $sessionNormale->note : 0);
                                $moyenne /= ($controleContinu && $sessionNormale) ? 2 : 1; // Éviter la division par zéro
                            @endphp
                            <tr>
                                <td class="py-2 px-4 border">{{ $etudiant->id }}</td>
                                <td class="py-2 px-4 border">{{ $etudiant->nom }} {{ $etudiant->prenom }}</td>
                                <td class="py-2 px-4 border">{{ $controleContinu ? $controleContinu->note : 'N/A' }}</td>
                                <td class="py-2 px-4 border">{{ $sessionNormale ? $sessionNormale->note : 'N/A' }}</td>
                                <td class="py-2 px-4 border">{{ $rattrapage ? $rattrapage->note : 'N/A' }}</td>
                                <td class="py-2 px-4 border">{{ number_format($moyenne, 2) }}</td>
                            </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $uniteValeurs->appends(request()->input())->links() }}
        </div>
    @endsection
</x-layout>
