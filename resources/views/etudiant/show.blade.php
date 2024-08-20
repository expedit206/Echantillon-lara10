<x-layout>
    @section('title', 'Teachers')

    @section('content')
    <x-header />
    <x-menu />
    <div class="max-w-5xl mx-auto p-8 bg-slate-300 rounded-lg shadow-lg mt-10">
        <div class="flex items-center space-x-4 mb-6">
            <img src="{{ $student->photo ? asset('storage/' . $student->photo) : 'https://via.placeholder.com/150' }}" alt="Photo de l'étudiant" class="w-32 h-32 object-cover rounded-full">
            <div>
                <p class="text-blue-600 underline ">
                    #{{ $student->code }}
                    </p>
                <h1 class="text-3xl font-bold mb-2">{{ $student->nom }} {{ $student->prenom }}</h1>
                <p class="text-gray-600 mb-4">{{ $student->filiere->nom }}</p>
            </div>
        </div>

        <div class="space-y-4">
            <div>
                <h2 class="text-xl font-semibold mb-2 text-indigo-600">Informations Personnelles</h2>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>Date de naissance :</strong> {{ $student->dateNaissance->format('d/m/Y') }}</p>
                    <p><strong>Lieu de naissance :</strong> {{ $student->lieuNaissance }}</p>
                    <p><strong>Nationalité :</strong> {{ $student->nationalite }}</p>
                    <p><strong>Sexe :</strong> {{ ucfirst($student->sexe) }}</p>
                    <p><strong>Mobile :</strong> {{ $student->telephone }}</p>
                    <p><strong>Email :</strong> {{ $student->email }}</p>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-semibold mb-2 text-indigo-600">Informations Académiques</h2>
                <div class="grid grid-cols-2 gap-4">
                    <p><strong>Niveau :</strong> {{ $student->niveau->nom }}</p>
                    <p><strong>Filière :</strong> {{ $student->filiere->nom }}</p>
                </div>
            </div>

            <div class="mt-6 flex justify-between">
                <a href="{{ route('students') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md shadow-sm hover:bg-gray-700">
                    Retour à la liste
                </a>
                <a href="{{ route('student.edit', $student->id) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500">
                    Éditer les informations
                </a>
            </div>
        </div>
    </div>
    @endsection
</x-layout>