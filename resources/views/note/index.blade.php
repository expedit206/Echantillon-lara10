<x-layout>
    @section('title', 'Notes des étudiants')

    @section('content')
    <x-header />
    <x-menu />

    <div class="filter mb-4">
        <!-- Formulaire de filtrage ici -->
    </div>

    <div class="indicators mt-4">
        <h2 class="text-xl font-bold">Année Académique : {{ $annee_academique }}</h2>
        <h3 class="text-lg italic">Semestre : {{ $semestre->nom ?? 'Non spécifié' }}</h3>
        <h3 class="text-lg italic">
            @foreach ($students as $student)
            Spécialité : {{ $student->specialite->nom ?? 'Non spécifié' }}</h3>
            @break
            @endforeach

    </div>

    <div class=" mt-3">
        <p class="font-bold text-xl italic">Total : {{ $students->total() }}</p> <!-- `total()` pour la pagination -->

        <table class="table-custom">
            <thead class="table-head-custom">
                <tr class="bg-none">
                    <th scope="col">Nom</th>
                    <th scope="col">Sexe</th>
                    <th scope="col">Unité de Valeur</th>
                    <th scope="col">Crédit</th>
                    <th scope="col">Contrôle Continu</th>
                    <th scope="col">Session Normale</th>
                    <th scope="col">Rattrapage</th> <!-- Nouvelle colonne pour le rattrapage -->
                    <th scope="col">relevé de notes</th> <!-- Nouvelle colonne pour le rattrapage -->
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    @php
                        $controleContinuNote = $student->notes
                            ->where('unite_valeur_id', request('matieres'))
                            ->where('type', 'Controle continu')
                            ->first();

                        $sessionNormaleNote = $student->notes
                            ->where('unite_valeur_id', request('matieres'))
                            ->where('type', 'Normale')
                            ->first();

                        $rattrapageNote = $student->notes
                            ->where('unite_valeur_id', request('matieres'))
                            ->where('type', 'Rattrapage')
                            ->first();
                    @endphp
                    <tr>
                        <td>{{ $student->nom }}</td>
                        <td>{{ $student->sexe }}</td>
                        <td>{{ $controleContinuNote->uniteValeur->nom ?? $sessionNormaleNote->uniteValeur->nom ?? $rattrapageNote->uniteValeur->nom ?? 'N/A' }}</td>
                        <td>{{ $controleContinuNote->uniteValeur->credit ?? $sessionNormaleNote->uniteValeur->credit ?? $rattrapageNote->uniteValeur->credit ?? 'N/A' }}</td>
                        <td>{{ $controleContinuNote->note ?? 'N/A' }}</td> <!-- Note pour le contrôle continu -->
                        <td>{{ $sessionNormaleNote->note ?? 'N/A' }}</td> <!-- Note pour la session normale -->
                        <td>{{ $rattrapageNote->note ?? 'N/A' }}</td> <!-- Note pour le rattrapage -->
                        <td class="">
                          <a href="{{ route('releve.show',['etudiant'=>$student->id, 'annee'=>request('annee') ]) }}" class="flex justify-center">
                            <svg width="50" height="25" viewBox="0 0 100 50"  xmlns="http://www.w3.org/2000/svg">
                                <!-- Contour de l'œil -->
                                <ellipse cx="50" cy="25" rx="45" ry="20" fill="none" stroke="#000" stroke-width="2"/>

                                <!-- Blanc de l'œil -->
                                <ellipse cx="50" cy="25" rx="44" ry="19" fill="#fff" />

                                <!-- Iris -->
                                <circle cx="50" cy="25" r="10" fill="#00f"/>

                                <!-- Pupille -->
                                <circle cx="50" cy="25" r="5" fill="#000"/>

                                <!-- Reflet -->
                                <circle cx="53" cy="22" r="2" fill="#fff"/>
                              </svg>

                          </a>
                          </td> <!-- Note pour le rattrapage -->
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">Aucun étudiant trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        {{ $students->appends(request()->input())->links() }}
    </div>
    @endsection
</x-layout>
