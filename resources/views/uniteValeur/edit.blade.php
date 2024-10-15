<x-layout>
    @section('title', 'modifier Unité de Valeur')
{{-- @dd($uniteValeur) --}}
    @section('content')
        <x-header />
        <x-menu />

        <div class="container mx-auto p-6">
            <div class="bg-slate-400 shadow-lg rounded-lg p-6">
                <h2 class="text-3xl font-bold mb-6">Créer une Unité de Valeur</h2>

                <form action="{{ route('uniteValeur.update', $uniteValeur->id) }}" method="POST">
                    @csrf
                    @method('put')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                            <label for="nom" class="text-gray-200 text-lg">Nom :</label>
                            <input type="text" id="nom" name="nom" class="text-xl text-gray-300 bg-gray-800 rounded-md" value="{{ $uniteValeur->nom }}">
                        </div>
                        <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                            <label for="category" class="text-gray-200 text-lg">Category :</label>
                            <select id="category" name="category_id" class="text-xl text-gray-300 bg-gray-800 rounded-md">
                                <!-- Options pour les catégories -->
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"  {{ $category->id == $uniteValeur->category_id? 'selected':'' }}>{{ $category->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                            <label for="credit" class="text-gray-200 text-lg">Crédit :</label>
                            <input type="number" id="credit" name="credit" class="text-xl text-gray-300 bg-gray-800 rounded-md" value="{{ $uniteValeur->credit }}">
                        </div>
                        <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                            <label for="description" class="text-gray-200 text-lg">Description :</label>
                            <textarea id="description" name="description" class="text-xl text-gray-300 bg-gray-800 rounded-md">{{ $uniteValeur->description }}</textarea>
                        </div>
                        <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                            <label for="semestre" class="text-gray-200 text-lg">Semestre :</label>
                            <select id="semestre" name="semestre_id" class="text-xl text-gray-300 bg-gray-800 rounded-md">
                                @foreach($semestres as $semestre)
                                    <option value="{{ $semestre->id }}"  {{ $semestre->id == $uniteValeur->semestre_id? 'selected':'' }}>{{ $semestre->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex flex-col bg-gray-700 p-4 rounded-md border border-gray-600">
                            <label for="annee" class="text-gray-200 text-lg">Année :</label>
                            <select id="annee" name="annee_id" class="text-xl text-gray-300 bg-gray-800 rounded-md">
                                @foreach($annees as $annee)
                                    <option value="{{ $annee->id }}">{{ $annee->nom }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md">Enregistrer</button>
                        <a href="{{ route('uniteValeur.index') }}" class="btn bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-md">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    @endsection
</x-layout>
