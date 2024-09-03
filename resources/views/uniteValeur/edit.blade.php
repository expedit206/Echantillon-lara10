<x-layout>

    @section('title', 'Édition de l\'Unité de Valeur')

    @section('content')
    <x-header />
    <x-menu />

    <div class="container mx-auto p-6">
        <div class="bg-slate-400  shadow-lg rounded-lg p-6">
            <h2 class="text-3xl font-bold mb-6">Édition de l'Unité de Valeur</h2>

            <form action="{{ route('uniteValeur.update', $uniteValeur->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1  gap-6 mb-6">
                    <div class="flex flex-col">
                        <label for="code" class="text-gray-900 font-bold">Code</label>
                        <input type="text" id="code" name="code" value="{{ old('code', $uniteValeur->code) }}" class="bg-gray-700 text-white rounded-md px-4 py-2" required>
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="nom" class="text-gray-900 font-bold">Nom</label>
                        <input type="text" id="nom" name="nom" value="{{ old('nom', $uniteValeur->nom) }}" class="bg-gray-700 text-white rounded-md px-4 py-2" required>
                        @error('nom')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex flex-col">
                        <label for="niveau" class="text-gray-900 font-bold">Niveau</label>
                        <select id="niveau" name="niveau_id" class="bg-gray-700 text-white rounded-md px-4 py-2">
                            @foreach ($niveaux as $niveau)
                                <option value="{{ $niveau->id }}" {{ $uniteValeur->niveau_id == $niveau->id ? 'selected' : '' }}>
                                    {{ $niveau->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('niveau_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="filiere" class="text-gray-900 font-bold">Filière</label>
                        <select id="filiere" name="filiere_id" class="bg-gray-700 text-white rounded-md px-4 py-2">
                            @foreach ($filieres as $filiere)
                                <option value="{{ $filiere->id }}" {{ $uniteValeur->filiere_id == $filiere->id ? 'selected' : '' }}>
                                    {{ $filiere->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('filiere_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="flex flex-col">
                        <label for="specialite" class="text-gray-900 font-bold">Spécialité</label>
                        <select id="specialite" name="specialite_id" class="bg-gray-700 text-white rounded-md px-4 py-2">
                            @foreach ($specialites as $specialite)
                                <option value="{{ $specialite->id }}" {{ $uniteValeur->specialite_id == $specialite->id ? 'selected' : '' }}>
                                    {{ $specialite->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('specialite_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col">
                        <label for="enseignant" class="text-gray-900 font-bold">Enseignant</label>
                        <select id="enseignant" name="enseignant_id" class="bg-gray-700 text-white rounded-md px-4 py-2">
                            <option value="">Non attribué</option>
                            @foreach ($enseignants as $enseignant)
                                <option value="{{ $enseignant->id }}" {{ $uniteValeur->enseignant_id == $enseignant->id ? 'selected' : '' }}>
                                    {{ $enseignant->nom }}
                                </option>
                            @endforeach
                        </select>
                        @error('enseignant_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-4">
                    <button type="submit" class="btn bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Modifier</button>
                    <a href="{{ route('uniteValeur.show', $uniteValeur->id) }}" class="btn bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">Annuler</a>
                </div>
            </form>
        </div>
    </div>

    @endsection
</x-layout>
