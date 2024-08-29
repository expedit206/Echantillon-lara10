<x-layout>
    @section('title','Notes des étudiants')

    @section('content')
    <x-header />
    <x-menu />

    <div class="filter">
        <!-- Formulaire de filtrage ici -->
    </div>

    <div class="indicators mt-4">
        <h2 class="text-xl font-bold">Année Académique : {{ $annee_academique }}</h2>
        <h3 class="text-lg italic">Semestre : {{ $semestre->nom ?? 'Non spécifié' }}</h3>
    </div>

    <div class="table-responsive mt-3">
        <p class="font-bold text-1xl italic">Total : {{ $students->total() }}</p> <!-- `total()` pour la pagination -->
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Sexe</th>
                    <th scope="col">Spécialité</th>
                    <th scope="col">Unité de Valeur</th>
                    <th scope="col">Crédit</th>
                    <th scope="col">Contrôle Continu</th>
                    <th scope="col">Session Normale</th>
                    <th scope="col">Rattrapage</th> <!-- Nouvelle colonne pour le rattrapage -->
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
                        <td>{{ $student->specialite->nom }}</td>
                        <td>{{ $controleContinuNote->uniteValeur->nom ?? $sessionNormaleNote->uniteValeur->nom ?? $rattrapageNote->uniteValeur->nom ?? 'N/A' }}</td>
                        <td>{{ $controleContinuNote->uniteValeur->credit ?? $sessionNormaleNote->uniteValeur->credit ?? $rattrapageNote->uniteValeur->credit ?? 'N/A' }}</td>
                        <td>{{ $controleContinuNote->note ?? 'N/A' }}</td> <!-- Note pour le contrôle continu -->
                        <td>{{ $sessionNormaleNote->note ?? 'N/A' }}</td> <!-- Note pour la session normale -->
                        <td>{{ $rattrapageNote->note ?? 'N/A' }}</td> <!-- Note pour le rattrapage -->
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
