<div id="notes-modal" class="flex ">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
        <h2 class="text-2xl font-semibold mb-6">Sélectionner les critères de notes</h2>
        <form id="notes-form" action="{{ route('notes.index') }}" method="GET">
            @csrf

            <label for="anneeModal" class="block mb-3 font-medium text-gray-700">Année académique</label>
            <select id="anneeModal" name="annee" class="block w-full mb-4 border bg-gray-400 rounded-lg p-3 cursor-pointer" required>
                @foreach ($annees as $annee)
                    <option value="{{ $annee->id }}">{{ $annee->nom }}</option>
                @endforeach
            </select>

            <label for="semestreModal" class="block mb-3 font-medium text-gray-700">Semestre</label>
            <select id="semestreModal" name="semestre" class="block w-full mb-4 border bg-gray-400 border-gray-300 rounded-lg p-3 cursor-pointer" required>
                @foreach ($semestres as $semestre)
                    <option value="{{ $semestre->id }}">{{ $semestre->nom }}</option>
                @endforeach
            </select>

            <!-- Nouveau champ pour le niveau -->
            <label for="niveauModal" class="block mb-3 font-medium text-gray-700">Niveau</label>
            <select id="niveauModal" name="niveau" class="block w-full mb-4 bg-gray-400 border border-gray-300 rounded-lg p-3 cursor-pointer" required>
                @foreach ($niveaux as $niveau)
                    <option value="{{ $niveau->id }}">{{ $niveau->nom }}</option>
                @endforeach
            </select>

            <label for="specialiteModal" class="block mb-3 font-medium text-gray-700">Spécialité</label>
            <select id="specialiteModal" name="specialite" class="block w-full mb-4 bg-gray-400 border border-gray-300 rounded-lg p-3 cursor-pointer" required>
                @foreach ($specialites as $specialite)
                    <option value="{{ $specialite->id }}">{{ $specialite->nom }}</option>
                @endforeach
            </select>

            <label for="matiereModal" class="block mb-3 font-medium text-gray-700">Matière</label>
            <select id="matiereModal" name="matieres" class="block w-full mb-6 border bg-gray-400 border-gray-300 rounded-lg p-3 cursor-pointer" required>
                @foreach ($matieres as $matiere)
                    <option value="{{ $matiere->id }}">{{ $matiere->nom }}</option>
                @endforeach
            </select>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600">Afficher les notes</button>
                <button type="button" id="close-modal" class="ml-4 px-4 py-2 bg-gray-500 text-white rounded-lg shadow-md hover:bg-gray-600">Annuler</button>
            </div>
        </form>
    </div>
</div>
<script>
</script>
