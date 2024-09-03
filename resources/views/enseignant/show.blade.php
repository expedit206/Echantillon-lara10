<x-layout>
    @section('title', 'Teachers')

    @section('content')
    <x-header />
    <x-menu />

    <div class="max-w-5xl mx-auto p-8 bg-slate-500 rounded-lg shadow-lg mt-10">
        <div class="bg-orange-500 p-4 rounded-t-lg text-white text-center">
            <h1 class="text-2xl font-bold">DÉTAIL ENSEIGNANT : [{{ strtoupper($enseignant->nom) }}]</h1>
            <p class="text-lg mt-2">PROFESSION : {{ $enseignant->profession }}</p>
        </div>

        <div class="flex justify-between mt-4 px-4">
            <a href="{{ route('teachers') }}" class="text-orange-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0L2.293 10.707a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L4.414 9H17a1 1 0 110 2H4.414l3.293 3.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour
            </a>
            <a href="{{ route('teacher.edit', $enseignant->id) }}" class="text-orange-500 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7.586 9.586a2 2 0 00-.586 1.414v3.414a1 1 0 001 1h3.414a2 2 0 001.414-.586l7-7a2 2 0 000-2.828zM7 12.414V10h2.414l6-6L13 4.414l-6 6zm2.707 2.293a1 1 0 00-1.414-1.414L7 14.586V17h2.414l1.293-1.293z" />
                </svg>
                Éditer les infos de l'enseignant
            </a>
        </div>

        <div class="mt-6 bg-gray-100 p-4 rounded-lg">
            <h2 class="text-xl font-semibold text-orange-500">IDENTIFICATION</h2>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="py-3 px-6 text-left">Prénom</th>
                            <th class="py-3 px-6 text-left">Nom</th>
                            <th class="py-3 px-6 text-left">Date Naiss</th>
                            <th class="py-3 px-6 text-left">Lieu Naiss</th>
                            <th class="py-3 px-6 text-left">Sexe</th>
                            <th class="py-3 px-6 text-left">Nationalité</th>
                            <th class="py-3 px-6 text-left">Mobile</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Photo</th>
                            <th class="py-3 px-6 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td class="py-3 px-6">{{ $enseignant->prenom }}</td>
                            <td class="py-3 px-6">{{ $enseignant->nom }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($enseignant->dateNaiss)->format('d F Y') }}</td>
                            <td class="py-3 px-6">{{ $enseignant->lieuNaiss }}</td>
                            <td class="py-3 px-6">{{ $enseignant->sexe }}</td>
                            <td class="py-3 px-6">{{ $enseignant->nationalite }}</td>
                            <td class="py-3 px-6">{{ $enseignant->mobile }}</td>
                            <td class="py-3 px-6">{{ $enseignant->email }}</td>
                            <td class="py-3 px-6"><img src="{{ $enseignant->photo ? asset('storage/' . $enseignant->photo) : 'https://via.placeholder.com/50' }}" class="w-10 h-10 rounded-full"></td>
                            <td class="py-3 px-6 text-center">
                                <a href="#" class="text-red-500 hover:text-red-700">Supprimer</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6 bg-gray-100 p-4 rounded-lg">
            <h2 class="text-xl font-semibold text-orange-500">INFORMATIONS PROFESSIONNELLES</h2>
            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white rounded-lg shadow-md">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="py-3 px-6 text-left">Profession</th>
                            <th class="py-3 px-6 text-left">Diplôme</th>
                            <th class="py-3 px-6 text-left">Salaire</th>
                            <th class="py-3 px-6 text-left">Type de contrat</th>
                            <th class="py-3 px-6 text-left">Début contrat</th>
                            <th class="py-3 px-6 text-left">Fin contrat</th>
                            <th class="py-3 px-6 text-left">Unité de Valeur</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <tr>
                            <td class="py-3 px-6">{{ $enseignant->profession }}</td>
                            <td class="py-3 px-6">{{ $enseignant->diplome }}</td>
                            <td class="py-3 px-6">{{ number_format($enseignant->salaire, 2, ',', ' ') }} €</td>
                            <td class="py-3 px-6">{{ $enseignant->typeContrat }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($enseignant->debutContrat)->format('d F Y') }}</td>
                            <td class="py-3 px-6">{{ $enseignant->finContrat ? \Carbon\Carbon::parse($enseignant->finContrat)->format('d F Y') : 'Indéterminée' }}</td>
                            <td class="py-3 px-6">{{ $enseignant->uniteValeur }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @endsection
</x-layout>
