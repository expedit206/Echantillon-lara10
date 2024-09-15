<x-layout>
    @section('title', 'Graphique du Cours')

    @section('content')
    <x-header />
    <x-menu />

    <div class="container mx-auto p-6 bg-slate-400">    
        <h1 class="text-4xl font-bold mb-8 text-center text-gray-800">Graphique du Cours: {{ $cours->nom }}</h1>

        <!-- Graphique -->
        <div class="mb-10">
            <canvas id="coursGraphique"></canvas>
        </div>

        <!-- Scripts pour Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var ctx = document.getElementById('coursGraphique').getContext('2d');
                var labels = @json($semestresNoms);
                var tauxCC = @json($tauxCC);
                var tauxSN = @json($tauxSN);
                var tauxR = @json($tauxR);

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Taux de Réussite Contrôle Continu',
                                data: tauxCC,
                                backgroundColor: 'rgba(75, 192, 192, 0.8)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Taux de Réussite Session Normale',
                                data: tauxSN,
                                backgroundColor: 'rgba(255, 159, 64, 0.8)',
                                borderColor: 'rgba(255, 159, 64, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Taux de Réussite Rattrapage',
                                data: tauxR,
                                backgroundColor: 'rgba(15, 159, 64, 0.7)',
                                borderColor: 'rgba(15, 159, 64, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    // text: 'Semestres'
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Taux de Réussite (%)'
                                }
                            }
                        }
                    }
                });
            });
        </script>
    </div>

    @endsection
</x-layout>
