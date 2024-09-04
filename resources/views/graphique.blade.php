<x-layout>
    @section('title', 'Tableau de Bord')

    @section('content')
        <x-header />
        <x-menu />

        <div class="bg-slate-300">
            <h2 class="text-3xl font-bold mb-6 text-gray-900">Évolution des Statistiques par Année</h2>
        
            <canvas id="evolutionChart" width="400" height="200"></canvas>
        
            <script>
                var ctx = document.getElementById('evolutionChart').getContext('2d');
                
                var evolutionChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($data['labels']) !!},
                        datasets: [
                            {
                                label: 'Étudiants',
                                data: {!! json_encode($data['etudiants']) !!},
                                borderColor: 'rgba(54, 162, 235, 1)',
                                backgroundColor: 'rgba(100, 255, 255, 0.7)',
                                fill: true,
                            },
                            {
                                label: 'Enseignants',
                                data: {!! json_encode($data['enseignants']) !!},
                                borderColor: 'rgba(5, 192, 192, 1)',
                                backgroundColor: 'rgba(5, 192, 192, 0.9)',
                                fill: true,
                            },
                            {
                                label: 'Unités de Valeur',
                                data: {!! json_encode($data['uniteValeurs']) !!},
                                borderColor: 'rgba(153, 102, 200, 1)',
                                backgroundColor: 'rgba(255, 102, 255, 0.8)',
                                fill: true,
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    
    @endsection
</x-layout>
 