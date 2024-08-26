<x-layout>
    @section('title', 'Supprimer l\'Unité de Valeur')

    @section('content')
        <x-header />
        <x-menu />

        <div class="container mx-auto mt-5">
            <h1 class="text-2xl font-bold text-red-600">Supprimer l'Unité de Valeur</h1>

            <p class="mt-4">Êtes-vous sûr de vouloir supprimer l'unité de valeur <strong>{{ $uniteDeValeur->nom }}</strong> ? Cette action est irréversible.</p>

            <div class="mt-4 flex space-x-2">
                <form action="{{ route('unites-de-valeur.destroy', $uniteDeValeur->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn text-white bg-red-500">Supprimer</button>
                </form>
                <a href="{{ route('unites-de-valeur.index') }}" class="btn text-white bg-gray-500">Annuler</a>
            </div>
        </div>
    @endsection
</x-layout>
