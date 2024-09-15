<x-layout>
    @section('title', 'Tableau de Bord Enseignant')

    @section('content')
    <x-header />
    <x-menu />

    <div class="container mx-auto p-6 bg-slate-400">
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Tableau de Bord Enseignant</h1>
<select name="" id="">

    <option value="">{{$annee}}</option>
</select>
        <!-- Statistiques Globales pour l'enseignant -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <!-- Cours enseignés -->
            <div class="bg-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    <img src="/dashboard/matiere.png" alt="Cours" class="w-[60%] h-[60%]">
                </div>
                <h2 class="text-2xl font-semibold mb-2 text-center">Total des Cours Enseignés</h2>
                <p class="text-4xl font-bold text-center">{{ $totalCours }}</p>
            </div>

            <!-- Étudiants inscrits -->
            <div class="bg-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <div class="flex justify-center mb-4">
                    <img src="/dashboard/matiere.png" alt="Étudiants" class="w-[60%] h-[60%]">
                </div>
                <h2 class="text-2xl font-semibold mb-2 text-center">Total des Étudiants Inscrits</h2>
                <p class="text-4xl font-bold text-center">{{ $totalEtudiants }}</p>
            </div>
        </div>

        <!-- Statistiques par Cours -->
        <div class="mb-10 overflow-hidden">
            <h2 class="text-3xl font-bold mb-6 text-gray-800">Statistiques par Cours</h2>

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($cours as $cour)
                    <div class="swiper-slide mb-8">
                        <div class="flex justify-between">
                            <h3 class="text-2xl font-semibold text-gray-700 mb-4">Cours : {{ $cour->nom }} (  semestre   {{$cour->semestre_id }} )</h3>
                            <a href="
                            {{ route('coursGraphique', $cour->id ) }}
                             " class="px-2 bg-blue-600 rounded-lg flex items-center h-[3rem] text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart" viewBox="0 0 24 24">
                                    <line x1="12" y1="20" x2="12" y2="10"></line>
                                    <line x1="18" y1="20" x2="18" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="16"></line>
                                </svg>
                                Graphique de la classe
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <!-- Étudiants par cours -->
                            <div class="bg-blue-600 text-white p-4 rounded-lg shadow-lg">
                                <h4 class="text-xl font-semibold mb-2">Étudiants</h4>
                                <p class="text-3xl font-bold">{{ $cour->etudiants_count }}</p>
                            </div>

                            <!-- Réussite par cours -->
                            <div class="bg-green-600 text-white p-4 rounded-lg shadow-lg">
                                <h4 class="text-xl font-semibold mb-2">Réussite</h4>
                                <p class="text-3xl font-bold">{{ $cour->reussite }}%</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
        </div>
            <div class="swiper-button-next  "></div>

        </div>

        <!-- Actions Rapides pour l'enseignant -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Gestion des Cours -->
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-3xl font-semibold mb-4">Mes Cours</h2>
                <a href="{{ route('uniteValeur.index') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg mb-4 transition duration-300">Voir mes Cours</a>
                <a href="{{ route('uniteValeur.create') }}" class="block bg-green-600 hover:bg-green-700 text-white text-center py-3 px-4 rounded-lg transition duration-300">Ajouter un Cours</a>
            </div>

            <!-- Gestion des Étudiants par cours -->
            <div class="bg-gray-800 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
                <h2 class="text-3xl font-semibold mb-4">Étudiants par Cours</h2>
                <a href="{{ route('students') }}" class="block bg-blue-600 hover:bg-blue-700 text-white text-center py-3 px-4 rounded-lg mb-4 transition duration-300">Voir les Étudiants Inscrits</a>
            </div>
        </div>
    </div>

    @endsection
</x-layout>
