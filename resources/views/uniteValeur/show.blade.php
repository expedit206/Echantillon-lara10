<x-layout>
    @section('title', 'Détails de l\'Unité de Valeur')

    @section('content')
        <x-header />
        <x-menu />

        <div class="container mx-auto mt-5">
            <h1 class="text-2xl font-bold">Détails de l'Unité de Valeur</h1>

            <div class="mt-4">
                <p><strong>Code : </strong>{{ $uniteValeur->code }}</p>
                <p><strong>Nom : </strong>{{ $uniteValeur->nom }}</p>
                <p><strong>Description : </strong>{{ $uniteValeur->description }}</p>
                <p><strong>Crédits : </strong>{{ $uniteValeur->credits }}</p>
            </div>
{{-- @dd($uniteValeur) --}}
            <div class="mt-4 flex space-x-2">
                <a href="{{ route('uniteValeur.edit',compact('uniteValeur')) }}" class="btn text-white bg-blue-500">Modifier</a>
                <form action="{{ route('uniteValeur.destroy', $uniteValeur) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette unité de valeur ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn text-white bg-red-500">Supprimer</button>
                </form>
            </div>
        </div>
    @endsection
</x-layout>
