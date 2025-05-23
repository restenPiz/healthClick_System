<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Total Products</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{$product}}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Total Sales</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">{{$sale}}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Deliveries</h3>
                <p class="text-md text-yellow-400">Pending: {{$deliveryP}}</p>
                <p class="text-md text-green-400">Delivered: {{$deliveryD}}</p>
            </div>
        </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Container dos gráficos --}}
                    <div class=" flex flex-col md:flex-row gap-6 justify-between">
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
    
    @script
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
    @endscript
</div>