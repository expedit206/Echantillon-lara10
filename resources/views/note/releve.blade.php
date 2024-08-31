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
                    <img src="logo_ecole.png" alt="Logo de l'école" class="mx-auto mb-2 w-24">
                    <p class="font-bold text-xl">École Supérieure La Canadienne</p>
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
        <div class="notes-tables">
            @foreach ($notes as $semestreNom => $matiereNotes)
                <div class="mb-8">
                    <h3 class="text-2xl font-semibold mb-4">{{ $semestreNom }}</h3>
                    <table class="table-auto w-full border border-gray-300">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="border px-4 py-2">Code UV</th>
                                <th class="border px-4 py-2">UV</th>
                                <th class="border px-4 py-2">Note/20</th>
                                <th class="border px-4 py-2">Crédit</th>
                                <th class="border px-4 py-2">Appréciation</th>
                                <th class="border px-4 py-2">Session de</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($matiereNotes as $note)
                                <tr class="hover:bg-gray-100">
                                    <td class="border px-4 py-2 text-center">{{ $note['code'] }}</td>
                                    <td class="border px-4 py-2">{{ $note['nom'] }}</td>
                                    <td class="border px-4 py-2 text-center">{{ number_format($note['note'], 2) }}</td>
                                    <td class="border px-4 py-2 text-center">{{ $note['credit'] }}</td>
                                    <td class="border px-4 py-2 text-center">{{ $note['appreciation'] }}</td>
                                    <td class="border px-4 py-2 text-center">{!! $note['session'] !!}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    </div>
    @endsection
</x-layout>
