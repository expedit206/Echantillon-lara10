<x-layout>
    @section('title', 'Tableau de Bord')

    @section('content')
    <x-header />
    <x-menu />

    <div class="container mx-auto p-6  bg-slate-400">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Tableau de Bord</h1>
<div class="flex items-center justify-end">

    <a href="{{ route('graphique') }}" class="mb-2 px-2 bg-blue-500 rounded-lg flex items-center h-[3rem] text-white">


          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
            <path d="M3 17l6-6 4 4 8-8"></path>
            <path d="M14 7h7v7"></path>
          </svg>

        Graphique de synthese</a>
</div>
        <!-- Statistiques Globales -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-10">
            <!-- Étudiants -->

            <div class="bg-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    <img src="/dashboard/matiere.png" alt="Étudiants" class="w-[60%] h-[60%]">
                </div>
                <h2 class="text-2xl font-semibold mb-2 text-center">Total des Étudiants</h2>
                <p class="text-4xl font-bold text-center">{{ $totalEtudiants }}</p>
            </div>

            <!-- Enseignants -->
            <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    <img src="/dashboard/matiere.png" alt="Enseignants" class="w-[60%] h-[60%]">
                </div>
                <h2 class="text-2xl font-semibold mb-2 text-center">Total des Enseignants</h2>
                <p class="text-4xl font-bold text-center">{{ $totalEnseignants }}</p>
            </div>

            <!-- Unités de Valeur -->
            <div class="bg-purple-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    <img src="/dashboard/matiere.png" alt="Unités de Valeur" class="w-[60%] h-[60%]">
                </div>
                <h2 class="text-2xl font-semibold mb-2 text-center">Total des Unités de Valeur</h2>
                <p class="text-4xl font-bold text-center">{{ $totalUnites }}</p>
            </div>
        </div>

        <!-- Statistiques par Année -->
        <div class="mb-10 overflow-hidden">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Statistiques par Année</h2>

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($annees as $annee)
                    <div class="swiper-slide mb-8">
                        <div class='flex justify-between'>

                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Année Académique : {{ $annee->nom }}</h3>
                            <a href="{{ route('NoteGraphique', $annee->id ) }}" class="px-2 bg-blue-600 rounded-lg flex items-center h-[3rem] text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart" viewBox="0 0 24 24">
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                  </svg>

                                Graphique de reussite</a>

                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Étudiants par année -->
                            <div class="bg-blue-600 text-white p-4 rounded-lg shadow-lg">
                                <h4 class="text-xl font-semibold mb-2">Étudiants</h4>
                                <p class="text-3xl font-bold">{{ $annee->etudiants_count }}</p>
                            </div>

                            <!-- Enseignants par année -->
                            <div class="bg-green-600 text-white p-4 rounded-lg shadow-lg">
                                <h4 class="text-xl font-semibold mb-2">Enseignants</h4>
                                <p class="text-3xl font-bold">{{ $annee->enseignants_count }}</p>
                            </div>

                            <!-- Unités de Valeur par année -->
                            <div class="bg-purple-600 text-white p-4 rounded-lg shadow-lg">
                                <h4 class="text-xl font-semibold mb-2">Unités de Valeur</h4>
                                <p class="text-3xl font-bold">{{ $annee->unite_valeurs_count }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->

                <!-- Add Navigation -->
                <div class="swiper-button-next  "></div>
            </div>
        </div>


        <!-- Actions Rapides -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Gestion des Étudiants -->
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-3xl font-semibold mb-4">Gestion des Étudiants</h2>
                <a href="{{ route('students') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg mb-4 transition duration-300">Voir les Étudiants</a>
                <a href="
                {{-- {{ route('student.create') }} --}}
                 " class="block bg-green-600 hover:bg-green-700 text-white text-center py-3 px-4 rounded-lg transition duration-300">Ajouter un Étudiant</a>
            </div>

            <!-- Gestion des Enseignants -->
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-3xl font-semibold mb-4">Gestion des Enseignants</h2>
                <a href="{{ route('teachers') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg mb-4 transition duration-300">Voir les Enseignants</a>
                <a href="
                {{-- {{ route('teachers.create') }} --}}
                 " class="block bg-green-600 hover:bg-green-700 text-white text-center py-3 px-4 rounded-lg transition duration-300">Ajouter un Enseignant</a>
            </div>

            <!-- Gestion des Unités de Valeur -->
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-3xl font-semibold mb-4">Gestion des Unités de Valeur</h2>
                <a href="{{ route('uniteValeur.index') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg mb-4 transition duration-300">Voir les Unités</a>
                <a href="{{ route('uniteValeur.create') }}" class="block bg-green-600 hover:bg-green-700 text-white text-center py-3 px-4 rounded-lg transition duration-300">Ajouter une Unité</a>
            </div>
        </div>
    </div>

    @endsection
</x-layout>
