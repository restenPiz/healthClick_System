<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Delivery Users') }}
            </h2>
        </div>
    </x-slot>

    {{--*Main Content--}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Formulário de Adição/Atualização -->
            <div class="lg:w-1/2 bg-white dark:bg-gray-800 p-6 shadow rounded-lg">
                <form wire:submit.prevent="store">
                    <div class="mb-4">
                        <label for="methodName" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Username
                        </label>
                        <x-text-input
                        wire:model.defer="username"
                        id="username"
                        name="username"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="{{ __('Username') }}"
                        autofocus />
                    </div>
                    <div class="mb-4">
                        <label for="methodName" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Email
                        </label>
                        <x-text-input
                        wire:model.defer="email"
                        id="email"
                        name="email"
                        type="text"
                        class="mt-1 block w-full"
                        placeholder="{{ __('Email') }}"
                        autofocus />
                    </div>
                    <div class="mb-4">
                        <label for="methodName" class="block text-gray-700 dark:text-gray-300 font-medium mb-2">
                            Password
                        </label>
                        <x-text-input
                        wire:model.defer="password"
                        id="password"
                        name="password"
                        type="password"
                        class="mt-1 block w-full"
                        autofocus />
                    </div>
                    <x-primary-button>
                        Add User
                    </x-primary-button>
                </form>
            </div>

            <!-- Tabela de Métodos -->
            <div class="lg:w-1/2 ">
                 {{--?Alert--}}
                <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="delivery-added">
                    {{ __('delivery added with successfuly') }}
                </x-action-message>
                <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="delivery-updated">
                    {{ __('delivery updated with successfuly') }}
                </x-action-message>
                <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="delivery-deleted">
                    {{ __('delivery deleted with successfuly') }}
                </x-action-message>
                <div style="margin-top:0.5rem"></div>
                {{--?End Alert--}}
                {{-- <h2 class="dark:text-gray-300 text-xl font-semibold mb-4">Category Methods</h2> --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                   Username
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                   Email
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            {{-- @foreach ($categories as $category) --}}
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{-- {{$category->category_name}} --}}Mauro Peniel
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        {{-- {{$category->category_name}} --}}mauropeniel7@gmail.com
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                        <button  x-data=""
                                            {{-- x-on:click.prevent="$wire.setCategoryToEdit({{ $category->id }}); $dispatch('open-modal', 'edit-pharmacy-modal')" --}}
                                            class="text-yellow-500 hover:text-yellow-600">
                                            Edit
                                        </button>
                                        <button
                                            class="ml-2 text-red-500 hover:text-red-600"
                                            {{-- wire:click="confirmDeletion({{ $category->id }})" --}}
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            {{-- @endforeach --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{--*End Main Content--}}
</div>
