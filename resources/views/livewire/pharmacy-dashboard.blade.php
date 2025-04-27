<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pharmacy Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Total Products</h3>
                <p class="text-3xl font-bold text-blue-600 mt-2">{{ $productCount }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Total Sales</h3>
                <p class="text-3xl font-bold text-green-600 mt-2">{{ $saleCount }}</p>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">Deliveries</h3>
                <p class="text-md text-yellow-400">Pending: {{ $deliveryStats['pendente'] }}</p>
                <p class="text-md text-green-400">Delivered: {{ $deliveryStats['entregue'] }}</p>
            </div>
        </div>

        {{-- Chart Section --}}
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">Delivery Status Chart</h3>
            <canvas id="deliveryChart" class="w-full max-w-md mx-auto h-64"></canvas>
        </div>
    </div>
    @script
    <script>
        const ctx = document.getElementById('deliveryChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pendente', 'Entregue'],
                datasets: [{
                    label: 'Entregas',
                    data: [{{ $deliveryStats['pendente'] }}, {{ $deliveryStats['entregue'] }}],
                    backgroundColor: ['#facc15', '#22c55e'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#fff'
                        }
                    }
                }
            }
        });
        
    </script>
    @endscript
</div>