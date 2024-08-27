<x-layout>
    @section('title', 'Modifier l\'Unité de Valeur')

    @section('content')
        <x-header />
        <x-menu />

        <div class="container mx-auto mt-5">
            <h1 class="text-2xl font-bold">Modifier l'Unité de Valeur</h1>

            <form action="{{ route('uniteValeur.update', $uniteValeur->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="code" class="block font-bold">Code</label>
                    <x-input type="text" name="code" id="code" value="{{ $uniteValeur->code }}" class="input w-full" />
                </div>

                <div class="mb-4">
                    <label for="nom" class="block font-bold">Nom</label>
                    <x-input type="text" name="nom" id="nom" value="{{ $uniteValeur->nom }}" class="input w-full" />
                </div>

                <div class="mb-4">
                    <label for="description" class="block font-bold">Description</label>
                    <textarea name="description" id="description" class="input w-full">{{ $uniteValeur->description }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="credits" class="block font-bold">Crédits</label>
                    <x-input type="number" name="credits" id="credits" value="{{ $uniteValeur->credit }}" class="input w-full" />
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn text-white bg-green-500">Enregistrer les modifications</button>
                </div>
            </form>
        </div>
    @endsection
</x-layout>
