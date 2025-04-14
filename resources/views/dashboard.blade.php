@role('admin')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    {{-- Container dos gráficos --}}
                    <div class="mt-10 flex flex-col md:flex-row gap-6 justify-between">
                        {{-- Bar Chart --}}
                        <div class="md:w-1/2 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow h-[300px] relative">
                            {{-- <h3 class="text-lg font-bold mb-2">Gráfico de Vendas (Bar)</h3> --}}
                            <canvas id="barChart" class="w-full h-full absolute top-0 left-0"></canvas>
                        </div>

                        {{-- Pie Chart --}}
                        <div class="md:w-1/2 bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow h-[300px] relative">
                            {{-- <h3 class="text-lg font-bold mb-2">Distribuição de Produtos (Pie)</h3> --}}
                            <canvas id="pieChart" class="w-full h-full absolute top-0 left-0"></canvas>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Bar Chart
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril'],
                datasets: [{
                    label: 'Vendas',
                    data: [150, 200, 180, 250],
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Medicamentos', 'Cosméticos', 'Suplementos', 'Outros'],
                datasets: [{
                    data: [40, 25, 20, 15],
                    backgroundColor: ['#4ade80', '#60a5fa', '#facc15', '#f87171'],
                    borderColor: '#1f2937',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</x-app-layout>
@endrole
