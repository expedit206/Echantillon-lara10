<x-layout>
    @section('title', 'Relevé de Notes')

    @section('content')
    <x-header />
    <x-menu />

    <div class="container mt-4">
        <h2 class="text-2xl font-bold mb-4">Relevé de Notes pour {{ $etudiant->nom }}</h2>
        
        @foreach($releve as $semestreNom => $matieres)
            <h3 class="text-xl font-semibold mt-4">{{ $semestreNom }}</h3>
            <table class="table-custom mt-2">
                <thead class="table-head-custom">
                    <tr>
                        <th>Matière</th>
                        <th>Note Finale</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($matieres as $matiereNom => $noteFinale)
                        <tr>
                            <td>{{ $matiereNom }}</td>
                            <td>{{ number_format($noteFinale, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
    @endsection
</x-layout>
