<x-layout>
    @section('title', 'Dashboard Étudiant')

    @section('content')
    <x-header />
    <x-menu />
    <div class="max-w-8xl mx-auto p-10 bg-slate-300 rounded-lg shadow-lg mt-10 flex flex-col justify-center">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <!-- Mes Cours -->
            <div class="bg-gray-800 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-4xl font-semibold mb-6 text-center">Mes Cours</h2>
                <a href="{{ route('uniteValeur.index') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-4 px-6 rounded-lg mb-4 transition duration-300">Liste des Cours</a>
                <a href="{{ route('uniteValeur.create') }}" class="block bg-green-600 hover:bg-green-700 text-white text-center py-4 px-6 rounded-lg transition duration-300">Ajouter un Cours</a>
            </div>

            <!-- Mes Enseignants -->
            <div class="bg-gray-800 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-4xl font-semibold mb-6 text-center">Mes Enseignants</h2>
                <a href="{{ route('teachers') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-4 px-6 rounded-lg mb-4 transition duration-300">Liste des Enseignants</a>
                <a href="{{ route('teachers') }}" class="block bg-green-600 hover:bg-green-700 text-white text-center py-4 px-6 rounded-lg transition duration-300">Chercher un Enseignant</a>
            </div>

            <!-- Mon Relevé -->
            <div class="bg-gray-800 text-white p-8 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-4xl font-semibold mb-6 text-center">Mon Relevé</h2>
                <a href="{{ route('releve.show', ['etudiant'=>$student,'annee'=>$annee_id]) }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-4 px-6 rounded-lg mb-4 transition duration-300">Consulter mon Relevé</a>
            </div>
        </div>

        <div class="mt-8 flex justify-between">
            <a href="{{ route('students') }}" class="inline-flex items-center px-6 py-3 bg-gray-800 text-white rounded-md shadow-sm hover:bg-gray-700">
                Retour à la liste
            </a>
            <a href="{{ route('student.edit', $student->id) }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500">
                Éditer les informations
            </a>
        </div>
    </div>
    @endsection
</x-layout>