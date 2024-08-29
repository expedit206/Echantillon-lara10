<x-layout>
    @section('title','Notes des étudiants')

    @section('content')
    <x-header />
    <x-menu />

    <div class="filter">
        <!-- ... Formulaire de filtrage ... -->
    </div>

    <div class="indicators mt-4">
        <h2 class="text-xl font-bold">Année Académique : {{ $annee_academique }}</h2>
        <h3 class="text-lg italic">Semestre : {{ $semestre->nom ?? 'Non spécifié' }}</h3>
    </div>

    <div class="table-responsive mt-3">
        <p class="font-bold text-1xl italic">Total : {{ $students->count() }}</p>
        <table class="table table-bordered table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Sexe</th>
                    <th scope="col">Spécialité</th>
                    <th scope="col">Filière</th>
                    <th scope="col">Unité de Valeur</th>
                    <th scope="col">Crédit</th>
                    <th scope="col">Contrôle Continu</th>
                    <th scope="col">Session Normale</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    @foreach ($student->notes as $note)
                    <tr>
                        <td>{{ $student->nom }}</td>
                        <td>{{ $student->sexe }}</td>
                            <td>{{ $student->specialite->nom }}</td>
                            <td>{{ $student->filiere->nom }}</td>
                            <td>{{ $note->uniteValeur->nom }}</td>
                            <td>{{ $note->uniteValeur->credit }}</td>
                            <td>{{ $note->controle_continu }}</td> <!-- Note pour le contrôle continu -->
                            <td>{{ $note->session_normale }}</td> <!-- Note pour la session normale -->
                        </tr>
                    @endforeach
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
