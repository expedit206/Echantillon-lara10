<x-layout>
    @section('title', 'Relevé de Notes')

    @section('content')
    <x-header />
    <x-menu />

    <div class="container mx-auto p-4">
        <div class="school-info text-center mb-8">
            <div class="flex justify-between items-center border-b border-gray-500 pb-4">
                <div class="text-left">
                    <p class="uppercase font-bold">République du Cameroun</p>
                    <p>Ministère de l’Enseignement Supérieur</p>
                    <p>École Supérieure La Canadienne</p>
                    <p>B.P. 831 Balesseng</p>
                    <p>Tél: +237 654 89 23 30 / 671 33 78 29</p>
                </div>
                <div class="text-center">
                    <img src="/build/assets/img/logoescajpg.jpg" alt="Logo de l'école" class="mx-auto mb-2 w-[12rem]">
                    {{-- <p class="font-bold text-xl">École Supérieure La Canadienne</p> --}}
                </div>
                <div class="text-right">
                    <p class="uppercase font-bold">Republic of Cameroon</p>
                    <p>Ministry of Higher Education</p>
                    <p>Canadian College</p>
                    <p>www.ecolacanadienne.com</p>
                    <p>contact@ecolacanadienne.com</p>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-lg uppercase font-bold">Relevé Annuel / Annual Transcript</p>
            </div>
        </div>

        <div class="student-info mb-4 grid grid-cols-2">
            <p><strong>Nom et Prénom étudiant : </strong>{{ $etudiant->nom }}  {{ $etudiant->prenom }}</p>
            <p><strong>Date et lieu de Naissance : </strong>{{ $etudiant->dateNaissance->format('Y . m . d') }} à {{ $etudiant->lieuNaiss }}</p>
            <p><strong>Niveau : </strong>{{ $etudiant->niveau->nom }}</p>
            <p><strong>Filière : </strong>{{ $etudiant->filiere->nom }}</p>
            <p><strong>Spécialité : </strong>{{ $etudiant->specialite->nom }}</p>
            <p><strong>Matricule : </strong>#{{ $etudiant->code }}</p>
            <p><strong>Année académique : </strong>{{ $anneeAcademique }}</p>
        </div>


        <div class="notes-tables">
            <!-- Ici viendrait le tableau des notes, comme montré dans les exemples précédents -->
        </div>
    </div>
    <div class="container mx-auto p-4">
        <!-- En-tête de l'école -->


        <!-- Tables des notes -->
        <div class="notes-tables p-6 bg-gray-100 rounded-lg shadow-lg">
            <table class="table-auto w-full border border-gray-300 rounded-lg overflow-hidden">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="border-b px-4 py-3 text-left font-semibold">Code UV</th>
                        <th class="border-b px-4 py-3 text-left font-semibold">UV</th>
                        <th class="border-b px-4 py-3 text-center font-semibold">Note/20</th>
                        <th class="border-b px-4 py-3 text-center font-semibold">Crédit</th>
                        <th class="border-b px-4 py-3 text-center font-semibold">Note * Crédit</th>
                        <th class="border-b px-4 py-3 text-center font-semibold">Appréciation</th>
                        <th class="border-b px-4 py-3 text-center font-semibold">Session de</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $i = 1;
                    @endphp

                    @foreach ($notes as $semestreNom => $matiereNotes)
                        @php
                            $totalCredit = 0;
                            $totalNoteCredit = 0;
                        @endphp

                        <tr>
                            <td colspan="7" class="bg-gray-100 text-gray-800 px-4 py-2  font-bold text-lg">
                                {{ $semestreNom }}
                            </td>
                        </tr>

                        @foreach ($matiereNotes as $note)
                            @php
                                $noteCredit = $note['note'] * $note['credit'];
                                $totalCredit += $note['credit'];
                                $totalNoteCredit += $noteCredit;
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-300">
                                <td class="border px-4 py-3 text-left">{{ $note['code'] }}</td>
                                <td class="border px-4 py-3 text-left">{{ $note['nom'] }}</td>
                                <td class="border px-4 py-3 text-center">{{ number_format($note['note'], 2) }}</td>
                                <td class="border px-4 py-3 text-center">{{ $note['credit'] }}</td>
                                <td class="border px-4 py-3 text-center">{{ number_format($noteCredit, 2) }}</td>
                                <td class="border px-4 py-3 text-center">{{ $note['appreciation'] }}</td>
                                <td class="border px-4 py-3 text-center">{!! $note['session'] !!}</td>
                            </tr>
                        @endforeach

                        <tr class="bg-gray-200 font-bold text-gray-800">
                            <td colspan="2" class="text-sm border px-4 py-3 text-center">TOTAL MOYENNE SEMESTRE {{ $i }}</td>
                            <td class="bg-gray-300 border px-4 py-3 text-center">
                                @if ($totalCredit > 0)
                                    {{ number_format($totalNoteCredit / $totalCredit, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="border px-4 py-3 text-center">{{ $totalCredit }}</td>
                            <td class="border px-4 py-3 text-center">{{ number_format($totalNoteCredit, 2) }}</td>
                            <td colspan="2" class="border px-4 py-3 text-center">
                                @if ($totalCredit > 0)
                                    @php
                                        $moyenne = $totalNoteCredit / $totalCredit;
                                        if ($moyenne >= 16) {
                                            echo 'Très bien';
                                        } elseif ($moyenne >= 14) {
                                            echo 'Bien';
                                        } elseif ($moyenne >= 12) {
                                            echo 'Assez bien';
                                        } elseif ($moyenne >= 10) {
                                            echo 'Passable';
                                        } else {
                                            echo 'Insuffisant';
                                        }
                                    @endphp
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>

                        @php
                            $i++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @endsection
</x-layout>
