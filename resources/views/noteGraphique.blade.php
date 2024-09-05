<x-layout>
    @section('title', 'Tableau de Bord')

    @section('content')
    <x-header />
    <x-menu />

    <div class="mb-10 bg-slate-300">
        <h2 class="text-3xl font-bold mb-6 ">Statistiques de reussite de l'année : {{ $annee }}</h2>

        <canvas id="evolutionChart" width="400" height="200"></canvas>
       {{-- @dd($reussiteGarcons) --}}

        <script>
            var ctx = document.getElementById('evolutionChart').getContext('2d');

            var evolutionChart = new Chart(ctx, {
                type: 'bar', // Utiliser 'bar' pour les pourcentages par genre et 'line' pour les globales
                data: {
                    labels: {!! json_encode(array_keys($reussiteGarcons->toArray())) !!}, // Les semestres
                    datasets: [
                        {
                            label: 'Garçons',
                            data: {!! json_encode(array_values($reussiteGarcons->toArray())) !!},
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.8)',
                            fill: true,
                            type: 'bar'
                        },
                        {
                            label: 'Filles',
                            data: {!! json_encode(array_values($reussiteFilles->toArray())) !!},
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            fill: true,
                            type: 'bar'
                        },
                        {
                            label: 'Global par semestre',
                            data: {!! json_encode(array_values($reussiteGlobaleSemestre->toArray())) !!},
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            fill: true,
                            type: 'line'
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Taux de Réussite (%)'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Évolution des taux de réussite par semestre'
                        }
                    }
                }
            });
</script>
<div class="mb-10">
<h2 class="text-3xl font-bold mb-6 text-gray-800">Statistiques globales</h2>

<canvas id="globalChart" width="400" height="200"></canvas>
</div>
{{-- @dd($reussiteGlobaleAnnee) --}}
<script>
            // Ajouter un graphique pour le taux de réussite global par année
            var ctxGlobal = document.getElementById('globalChart').getContext('2d');

            var globalChart = new Chart(ctxGlobal, {
                type: 'bar',
                data: {
                    labels: ['Garçons', 'Filles', 'Global'],
                    datasets: [
                        {
                            label: 'Taux de Réussite Global',
                            data: {!! json_encode(array_values($reussiteGlobaleAnnee)) !!},
                            borderColor: 'rgba(153, 102, 255, 1)',
                            backgroundColor: 'rgba(153, 102, 255, 0.6)',
                            fill: true,
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Taux de Réussite Global (%)'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Taux de Réussite Global pour l\'année'
                        }
                    }
                }
            });
        </script>
    </div>
<div class='flex justify-end'>

    <a href="{{ route('dashboard') }}" class="bg-red-500 p-2 rounded-lg flex items-center w-24 text-white font-bold">Retour</a>
</div>
    @endsection
</x-layout>
