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
                        <x-text-input
                        wire:model.defer="method_name"
                        id="method_name"
                        name="method_name"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="{{ __('Method Name') }}"
                        autofocus />
                    </div>
                    <x-primary-button>
                        Add
                    </x-primary-button>
                </form>
            </div>

            <!-- Tabela de Métodos -->
            <div class="lg:w-1/2 bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                 {{--?Alert--}}
                <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="payment-added">
                    {{ __('payment added with successfuly') }}
                </x-action-message>
                <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="payment-updated">
                    {{ __('payment updated with successfuly') }}
                </x-action-message>
                <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="payment-deleted">
                    {{ __('payment deleted with successfuly') }}
                </x-action-message>
                <div style="margin-top:0.5rem"></div>
                {{--?End Alert--}}
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
                            @foreach ($payments as $payment)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{$payment->method_name}}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <button  x-data=""
                                            x-on:click.prevent="$wire.setPaymentToEdit({{ $payment->id }}); $dispatch('open-modal', 'edit-pharmacy-modal')"
                                            class="text-yellow-500 hover:text-yellow-600">
                                            Editar
                                        </button>
                                        <button
                                            class="ml-2 text-red-500 hover:text-red-600"
                                            wire:click="confirmDeletion({{ $payment->id }})"
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--?Modal to delete payment--}}
    <x-modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable>
        <form wire:submit.prevent="deletePayment" class="p-6">

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to eliminate this payment?') }}
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

    {{--?Start with the editModal--}}
    <x-modal name="edit-pharmacy-modal" :show="false" focusable>
        <form wire:submit.prevent="updatePayment" class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Edit Payment Methods') }}
            </h2>

            <div class="mt-4">
                <x-input-label for="method_name" value="Payment Method Name" />
                <x-text-input id="method_name" wire:model.defer="editPayment.method_name" class="mt-1 block w-full" />
                <x-input-error :messages="$errors->get('method_name')" class="mt-2" />
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
    {{--?End of the editModal--}}

    {{-- ?End of the main content --}}
</div>
