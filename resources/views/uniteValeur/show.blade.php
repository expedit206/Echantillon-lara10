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
                    <strong class="text-gray-200 text-lg">Code :</strong>
                    <p class="text-xl text-gray-300">{{ $unitevaleur->code }}</p>
                </div>
                <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                    <strong class="text-gray-200 text-lg">Nom :</strong>
                    <p class="text-xl text-gray-300">{{ $unitevaleur->nom }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                    <strong class="text-gray-200 text-lg">Niveau :</strong>
                    <p class="text-xl text-gray-300">{{ $unitevaleur->niveau->nom }}</p>
                </div>
                <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                    <strong class="text-gray-200 text-lg">Filière :</strong>
                    <p class="text-xl text-gray-300">{{ $unitevaleur->filiere->nom }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                    <strong class="text-gray-200 text-lg">Spécialité :</strong>
                    <p class="text-xl text-gray-300">{{ $unitevaleur->specialite->nom }}</p>
                </div>
                <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                    <strong class="text-gray-200 text-lg">Enseignant :</strong>
                    <p class="text-xl text-gray-300">{{ $unitevaleur->enseignant?->nom ?? 'Non attribué' }}</p>
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('uniteValeur.edit', $unitevaleur->id) }}" class="btn bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-md">Éditer</a>
                <a href="{{ route('uniteValeur.index') }}" class="btn bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-md">Retour à la liste</a>
            </div>
        </div>
    </div>

    @endsection
</x-layout>
