<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Pharmacy') }}
            </h2>
            <a href=""
                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition">
                + Add Pharmacy
            </a>
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
    {{-- End of the main content --}}
</div>
