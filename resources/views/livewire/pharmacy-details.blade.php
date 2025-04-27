<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pharmacy Details') }}
            </h2>
            <a href="{{ route('pharmacy') }}" wire:navigate
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                {{ __('← Back') }}
            </a>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 shadow rounded-xl overflow-hidden">
            <div class="p-6">
                @if($pharmacy->pharmacy_file)
                    <img src="{{ Storage::url($pharmacy->pharmacy_file) }}"
                        alt="Imagem da Farmácia"
                        class="w-full h-64 object-cover rounded-lg shadow "><br>
                @endif

                <h1 class="text-3xl font-extrabold text-gray-800 dark:text-white mb-4">
                    {{ $pharmacy->pharmacy_name }}
                </h1>

                <div class="space-y-2 text-gray-700 dark:text-gray-300">
                    <p><strong class="text-indigo-600">📍 Localização:</strong> {{ $pharmacy->pharmacy_location }}</p>
                    <p><strong class="text-indigo-600">📞 Contacto:</strong> +258 {{ $pharmacy->pharmacy_contact }}</p>
                    <p><strong class="text-indigo-600">👨‍⚕️ Gerente:</strong> {{ $pharmacy->user->name }} ({{ $pharmacy->user->email }})</p>
                    <p><strong class="text-indigo-600">📝 Descrição:</strong> {{ $pharmacy->pharmacy_description }}</p>

                    {{--? Mapa --}}
                    <div id="map" class="w-full h-64 mt-6 rounded-lg shadow"></div>
                </div>
            </div>
        </div>
    </div><br><br>
    
    @script
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const latitude = {{ $pharmacy->latitude }};
            const longitude = {{ $pharmacy->longitude }};

            const map = L.map('map').setView([latitude, longitude], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup(`<strong>{{ $pharmacy->pharmacy_name }}</strong><br>{{ $pharmacy->pharmacy_location }}`)
                .openPopup();
        });
    </script>
    @endscript
</div>
