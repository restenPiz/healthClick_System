@role('pharmacy')
<div>
    
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Sales') }}
            </h2>
        </div>
    </x-slot>
    
    {{--*Main Content--}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                <div>
                    <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                        <span class="sr-only">Action button</span>
                        Action
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate account</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete User</a>
                        </div>
                    </div>
                    
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for products">
                </div>
            </div>

            {{--?Alerts--}}
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="sale-updated">
                {{ __('Sale updated with successfuly') }}
            </x-action-message>
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="sale-deleted">
                {{ __('Sale deleted with successfuly') }}
            </x-action-message>
            {{--?End Alert--}}
            <div style="margin-top:0.5rem"></div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        {{-- <th class="p-4"><input type="checkbox"></th> --}}
                        <th class="px-6 py-3">Product name</th>
                        <th class="px-6 py-3">Category</th>
                        <th class="px-6 py-3">Quantity</th>
                        <th class="px-6 py-3">Sold At</th>
                        <th class="px-6 py-3">Price</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sales as $sale)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            {{-- <td class="p-4"><input type="checkbox"></td> --}}
                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-5 h-5 rounded-full" src="{{ asset('storage/' . $sale->product->product_file) }}" alt="product image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ $sale->product->product_name }}</div>
                                </div>  
                            </th>
                            <td class="px-6 py-4">{{ $sale->product->category->category_name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $sale->quantity }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($sale->sold_at)->format('d/m/Y H:i') }}</td>
                            <td class="px-6 py-4">{{ number_format($sale->price, 2) }} MZN</td>
                            <td class="px-6 py-4">{{ number_format($sale->quantity * $sale->price, 2) }} MZN</td>
                            <td class="flex items-center px-6 py-4">
                                 <a href="#" wire:click="confirmDeletion({{ $sale->id }})"
                                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                                    class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4 flex justify-center">
                {{ $sales->links() }}
            </div>
            {{--*Delete Modal--}}
            <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
                <form wire:submit.prevent="deleteSale" class="p-6">

                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        {{ __('Are you sure you want to eliminate this product?') }}
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
            {{--*End of modal--}}
        <br>
    </div>
    {{--*End Main Content--}}

</div>
@endrole