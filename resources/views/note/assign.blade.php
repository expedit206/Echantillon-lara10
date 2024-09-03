<x-layout>

    @section('title', 'Attribution des Notes')

    @section('content')
    <x-header />
    <x-menu />

    <div class="container mx-auto p-6">
        <div class="bg-gray-800 text-white shadow-lg rounded-lg p-6">
            <h2 class="text-3xl font-bold mb-6">Attribuer des Notes</h2>

            <form action="{{ route('notes.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Année académique -->
                    <div class="flex flex-col">
                        <label for="annee" class="block mb-2 font-medium text-gray-300">Année académique</label>
                        <select id="annee" name="annee" class="block w-full bg-gray-600 border border-gray-500 rounded-lg p-3" required>
                            @foreach ($annees as $annee)
                                <option value="{{ $annee->id }}">{{ $annee->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Semestre -->
                    <div class="flex flex-col">
                        <label for="semestre" class="block mb-2 font-medium text-gray-300">Semestre</label>
                        <select id="semestre" name="semestre" class="block w-full bg-gray-600 border border-gray-500 rounded-lg p-3" required>
                            @foreach ($semestres as $semestre)
                                <option value="{{ $semestre->id }}">{{ $semestre->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Matière -->
                    <div class="flex flex-col">
                        <label for="matiere" class="block mb-2 font-medium text-gray-300">Matière</label>
                        <select id="matiere" name="matiere" class="block w-full bg-gray-600 border border-gray-500 rounded-lg p-3" required>
                            @foreach ($matieres as $matiere)
                                <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Étudiants et Notes -->
                    <div class="flex flex-col">
                        <label for="notes" class="block mb-2 font-medium text-gray-300">Notes</label>
                        <div id="notes-container">
                            @foreach ($etudiants as $etudiant)
                                <div class="flex justify-between mb-2">
                                    <span>{{ $etudiant->nom }}</span>
                                    <input type="number" name="notes[{{ $etudiant->id }}]" class="w-full bg-gray-600 border border-gray-500 rounded-lg p-2" min="0" max="20" step="0.01" placeholder="Note" required>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600">Attribuer les notes</button>
                </div>
            </form>
        </div>
    </div>

    @endsection

</x-layout>
