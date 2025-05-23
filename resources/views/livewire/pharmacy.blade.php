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
            {{--?Alert--}}
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="pharmacy-added">
                {{ __('Pharmacy added with successfuly') }}
            </x-action-message>
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="pharmacy-updated">
                {{ __('Pharmacy updated with successfuly') }}
            </x-action-message>
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="pharmacy-deleted">
                {{ __('Pharmacy deleted with successfuly') }}
            </x-action-message>
            {{--?End Alert--}}
            <div style="margin-top:0.5rem"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($pharmacies as $pharmacy)
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">{{ $pharmacy->pharmacy_name }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Location: {{ $pharmacy->pharmacy_location }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Manager: {{ $pharmacy->user->name }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Manager Email: {{ $pharmacy->user->email }}
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        Contact: +258 {{ $pharmacy->pharmacy_contact }}
                    </p>
                    <div class="mt-4 flex items-center space-x-4">
                        <a wire:navigate href="{{ route('pharmacyDetails', $pharmacy->id) }}"
                            class="text-indigo-600 hover:underline dark:text-indigo-400">
                            More Details
                        </a>
                        {{--*Edit Button--}}
                        <x-primary-button
                            x-data=""
                            x-on:click.prevent="$wire.setPharmacyToEdit({{ $pharmacy->id }}); $dispatch('open-modal', 'edit-pharmacy-modal')"
                        >
                            {{ __('Edit') }}
                        </x-primary-button>
                        {{--*Delete Button--}}
                        <x-danger-button
                            wire:click="confirmDeletion({{ $pharmacy->id }})"
                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        >
                            {{ __('Delete') }}
                        </x-danger-button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

     {{--?Modal to delete pharmacy--}}
    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="deletePharmacy" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to eliminate this pharmacy?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
               This action is irreversible. Click delete to continue.
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
    {{--?End of modal--}}

    {{--?Start Modal Edit--}}
    <x-modal name="edit-pharmacy-modal" :show="false" focusable>
        <form wire:submit.prevent="updatePharmacy" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Pharmacy') }}
            </h2>

            <div class="mt-4">
                <x-input-label for="pharmacy_name" value="Pharmacy Name" />
                <x-text-input id="pharmacy_name" wire:model.defer="editPharmacy.pharmacy_name" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('pharmacy_name')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="pharmacy_contact" value="Contact" />
                <x-text-input id="pharmacy_contact" wire:model.defer="editPharmacy.pharmacy_contact" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('pharmacy_contact')" class="mt-2" />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">{{ __('Pharmacy Image') }}</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        @if ($editPharmacy['pharmacy_file'] && !is_string($editPharmacy['pharmacy_file']))
                            <img src="{{ $editPharmacy['pharmacy_file']->temporaryUrl() }}" class="mx-auto h-32 object-cover">
                        @elseif($editPharmacy['pharmacy_file'])
                            <img src="{{ asset('storage/'.$editPharmacy['pharmacy_file']) }}" class="mx-auto h-32 object-cover">
                        @else
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        @endif
                        <div class="flex text-sm text-gray-600">
                            <label for="pharmacy_file" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                <span>{{ __('Click to upload') }}</span>
                                <input id="pharmacy_file" wire:model="editPharmacy.pharmacy_file" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">{{ __('or drag and drop') }}</p>
                        </div>
                        <p class="text-xs text-gray-500">
                            {{ __('SVG, PNG, JPG or GIF (MAX. 800x400px)') }}
                        </p>
                        @error('editPharmacy.pharmacy_file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-primary-button class="ms-3">
                    {{ __('Update') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
    {{--?End of Modal Edit--}}

    {{--?Modal to add Pharmacy--}}
    <x-modal name="add-pharmacy" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="save" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('New Pharmacy') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Fill in the details for the new user.') }}
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
                <x-input-label for="pharmacy_contact" value="{{ __('Pharmacy_contact') }}" />
                <x-text-input
                    wire:model.defer="pharmacy_contact"
                    id="pharmacy_contact"
                    name="pharmacy_contact"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="{{ __('Contact: +258 867336817') }}"
                    autofocus />
                <x-input-error :messages="$errors->get('pharmacy_contact')" class="mt-2" />
            </div>

            {{-- <div class="mt-4">
                <x-input-label for="pharmacy_location" value="{{ __('Pharmacy Location') }}" />
                <input type="hidden" wire:model.defer="pharmacy_location" id="pharmacy_location">
                <div id="map" class="mt-2 h-64 w-full rounded-md border border-gray-300"></div>
                <x-input-error :messages="$errors->get('pharmacy_location')" class="mt-2" />
            </div> --}}
            <div class="mt-4">
                <x-input-label for="pharmacy_file" value="{{ __('Image') }}" />
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input wire:model="pharmacy_file" id="dropzone-file" type="file"  class="hidden"/>
                        <x-input-error :messages="$errors->get('pharmacy_file')" class="mt-2" />
                    </label>
                </div> 
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

    @script
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-o9N1jbd3L9x5H7bbP/H0tpUV1o6RzA2GDXbVmgePfXw=" crossorigin=""></script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBU6gQ1_MjMZOE35nYQ6-ovXw4er01wiuQ&callback=initMap"></script>
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
@endscript

</div>
  