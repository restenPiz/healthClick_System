<div>

    {{-- ?Start the main content --}}
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Payment Methods') }}
            </h2>
        </div>
    </x-slot>
    <div class="container mx-auto px-4 py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Formulário de Adição/Atualização -->
            <div class="lg:w-1/2 bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                <h2 class="text-xl text-gray-100 font-semibold mb-4">
                 Add Payment Methods
                </h2>
                <form wire:submit.prevent="save">
                    <div class="mb-4">
                        <label for="methodName" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Nome do Método
                        </label>
                        <input wire:model="methodName" id="methodName" type="text" placeholder="Ex: Cartão, M-Pesa"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:border-indigo-500">
                    </div>
                    <x-primary-button>
                        Add
                    </x-primary-button>
                </form>
            </div>

            <!-- Tabela de Métodos -->
            <div class="lg:w-1/2 bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                <h2 class="text-gray-100 text-xl font-semibold mb-4">Payment Methods</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Nome do Método
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        Mpesa
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <button wire:click=""
                                            class="text-yellow-500 hover:text-yellow-600">
                                            Editar
                                        </button>
                                        <button wire:click=""
                                            class="ml-2 text-red-500 hover:text-red-600"
                                            onclick="confirm('Tem certeza que deseja excluir este método?') || event.stopImmediatePropagation()">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ?End of the main content --}}

</div>
