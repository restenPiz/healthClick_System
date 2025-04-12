<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pharmacy') }}
            </h2>
            <button class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition"
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-pharmacy')">
                {{ __('+ Add Pharmacy') }}
            </button>
        </div>
    </x-slot>

    {{-- Start the main content --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">Farmacia Tuia</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Localização: Cidade da Beira
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Contacto: +867336817
                    </p>
                    <div class="mt-4 flex items-center space-x-4">
                        <a href=""
                            class="text-indigo-600 hover:underline dark:text-indigo-400">
                            More Details
                        </a>
                        <a href=""
                            class="text-yellow-500 hover:underline dark:text-yellow-400">
                            Edit
                        </a>
                        <form action="" method="POST" onsubmit="return confirm('Tens certeza que desejas eliminar?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline dark:text-red-400">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{--?Modal to add Pharmacy--}}
    <x-modal class="modal fade {{ $showModal ? 'show' : '' }}"
    name="add-pharmacy" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="save" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Add New Pharmacy') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Fill in the details for the new pharmacy.') }}
            </p>
            
            <div class="mt-4">
                <x-input-label for="Username" value="{{ __('Username') }}" />
                <x-text-input
                    wire:model.defer="name"
                    id="name"
                    name="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Enter Username') }}"
                    autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="Email" value="{{ __('Email') }}" />
                <x-text-input
                    wire:model.defer="email"
                    id="email"
                    name="email"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Enter Email') }}"
                    autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="mt-4">
                <x-input-label for="Password" value="{{ __('Password') }}" />
                <x-text-input
                    wire:model.defer="password"
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Enter Password') }}"
                    autofocus />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
            <br>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Fill in the details for the new pharmacy.') }}
            </p>
            <div class="mt-4">
                <x-input-label for="pharmacy_name" value="{{ __('Pharmacy Name') }}" />
                <x-text-input
                    wire:model.defer="pharmacy_name"
                    id="pharmacy_name"
                    name="pharmacy_name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Enter Pharmacy Name') }}"
                    autofocus />
                <x-input-error :messages="$errors->get('pharmacy_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="pharmacy_location" value="{{ __('Pharmacy Location') }}" />
                <input type="hidden" wire:model.defer="pharmacy_location" id="pharmacy_location">
                <div id="map" class="mt-2 h-64 w-full rounded-md border border-gray-300"></div>
                <x-input-error :messages="$errors->get('pharmacy_location')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="pharmacy_description" value="{{ __('Pharmacy Description') }}" />
                <textarea 
                    wire:model.defer="pharmacy_description"
                    id="pharmacy_description"
                    name="pharmacy_description"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm"
                    placeholder="{{ __('Enter Description') }}"
                    rows="5"></textarea>
                <x-input-error :messages="$errors->get('pharmacy_description')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="mr-3">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button type="submit">
                    {{ __('Save Pharmacy') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
     
    <!-- Overlay do modal -->
    @if($showModal)
    <div class="modal-backdrop fade show"></div>
    @endif

    {{--?Script--}}
    <script>
        let map;
        let marker;

        window.initMap = function () {
            // Localização padrão (ex: Beira, Moçambique)
            const initialLatLng = { lat: -19.8333, lng: 34.8500 };

            map = new google.maps.Map(document.getElementById("map"), {
                center: initialLatLng,
                zoom: 13,
            });

            map.addListener("click", (e) => {
                const lat = e.latLng.lat().toFixed(6);
                const lng = e.latLng.lng().toFixed(6);

                // Atualiza o campo de localização no formulário
                const input = document.getElementById("pharmacy_location");
                input.value = `${lat},${lng}`;
                input.dispatchEvent(new Event('input'));

                // Atualiza o Livewire (se necessário)
                Livewire.find('{{ $this->id }}').set('pharmacy_location', `${lat},${lng}`);

                // Adiciona ou move o marcador
                if (!marker) {
                    marker = new google.maps.Marker({
                        position: e.latLng,
                        map: map,
                    });
                } else {
                    marker.setPosition(e.latLng);
                }
            });
        }
    </script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6gQ1_MjMZOE35nYQ6-ovXw4er01wiuQ&callback=initMap"></script>
    

    {{-- End of the main content --}}
</div>
