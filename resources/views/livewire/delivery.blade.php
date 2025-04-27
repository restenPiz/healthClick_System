<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Delivery') }}
            </h2>
        </div>
    </x-slot>

    {{--*Form to filter the datas--}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <select id="countries" wire:model.live="status" {{--wire:model="status"--}} class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="">Select the option</option>
                        <option value="pendente">Pendente</option>
                        <option value="entregue">Entregue</option>
                    </select>
                </div>
                {{-- <div>
                    <button wire:click="filter" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Filtrar
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- Start the main content --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            {{--?Alert--}}
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="delivery-updated">
                {{ __('Product successfully delivered') }}
            </x-action-message>
            {{--?End Alert--}}
            <div style="margin-top:0.5rem"></div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($deliveries as $delivery)
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-md p-6 border border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white">DELIVERY CODE DV{{ $delivery->id }}</h3>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                       Owner: {{ $delivery->sale->user->name}}
                    </p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                       Owner Email: {{ $delivery->sale->user->email}}
                    </p>
                    <p class=" mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Location: {{ $delivery->delivery_address}}
                    </p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Contact: +258 {{ $delivery->contact }}
                    </p>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        Status: @if ($delivery->status=='pendente')
                        <span style="color:yellow">{{ $delivery->status }}</span>
                        @else
                        <span style="color:green">{{ $delivery->status }}</span>
                        @endif
                    </p>
                    <div class=" mt-4 flex items-center space-x-4">
                        <button type="submit" class="text-white bg-gradient-to-r from-green-500 via-green-600 to-green-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">More Details</button>
                         @if($delivery->status=='entregue')

                         @else
                        <button wire:click="confirmDelivery({{ $delivery->id }})"
                            class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Confirm
                        </button>
                         @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div><br><br>
</div>
