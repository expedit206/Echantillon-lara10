<x-layout>

    @section('title', 'Détails de l\'Unité de Valeur')

    @section('content')
        <x-header />
        <x-menu />

        <div class="container mx-auto p-6">
            <div class="bg-slate-400 shadow-lg rounded-lg p-6">
                <h2 class="text-3xl font-bold mb-6">Détails de l'Unité de Valeur</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">ID :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->id }}</p>
                    </div>
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">Nom :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->nom }}</p>
                    </div>
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">Category :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->category->nom }}</p>
                    </div>
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">Credit :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->credit }}</p>
                    </div>
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">Description :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->description }}</p>
                    </div>
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">Semestre :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->semestre->nom }}</p>
                    </div>
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">annee :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->annee->nom }}</p>
                    </div>
                    @if ($student = auth()->guard('etudiant')->user())
                        
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">Professeur :</strong>
                        <p class="text-xl text-gray-300">
                            @foreach ( $unitevaleur->enseignants as $enseignant )
                            @foreach ($enseignant->specialites as $specialite)
                            @if ($student->specialite_id == $specialite->id )
                            {{ $enseignant->nom }}
                            @endif
                            @endforeach
                            @endforeach
                        </p>
                    </div>
                    @else
                    <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                        <strong class="text-gray-200 text-lg">Créé le :</strong>
                        <p class="text-xl text-gray-300">{{ $unitevaleur->created_at }}</p>
                    </div>

                    @endif

                </div>

            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('uniteValeur.edit', $unitevaleur->id) }}"
                    class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md">Éditer</a>
                <a href="{{ route('uniteValeur.index') }}"
                    class="btn bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-md">Retour à la liste</a>
               <form action="{{ route('uniteValeur.destroy', $unitevaleur->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette unité de valeur ?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-md">
        Supprimer
    </button>
</form>

            </div>
        </div>
        </div>

    @endsection
</x-layout>
