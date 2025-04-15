@role('pharmacy')
<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('New Product') }}
            </h2>
            
            <a href="{{route('product')}}" wire:navigate class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700 transition"
                >
                {{ __('← Back') }}
            </a>
        </div>
    </x-slot>

    {{-- ?Start the main content --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            {{--?Alert--}}
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="product-added">
                {{ __('Product added with successfuly') }}
            </x-action-message>
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="product-updated">
                {{ __('Product updated with successfuly') }}
            </x-action-message>
            <x-action-message class="me-3 bg-green-700 rounded text-white dark:text-white" on="product-deleted">
                {{ __('Product deleted with successfuly') }}
            </x-action-message>
            {{--?End Alert--}}
            <div style="margin-top:0.5rem"></div>
            <form wire:submit="save">
                <div class="grid gap-6 mb-6 md:grid-cols-2">
                    <div>
                        <label for="product_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Name</label>
                        <input type="text" wire:model="product_name" id="product_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Paracetamol" required />
                    </div>
                    <div>
                        <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                        <input type="number" id="last_name" wire:model="product_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="100 MZN" required />
                    </div>
                    <div>
                        <label for="website" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantity</label>
                        <input type="number" id="website" wire:model="quantity" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="10" required />
                    </div>
                    <div>
                        <label for="countries" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="countries" wire:model="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">Select the category</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Image</label>
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-60 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input wire:model="product_file" id="dropzone-file" type="file" class="hidden" />
                        </label>
                    </div>
                    <div>    
                        <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Description</label>
                        <textarea wire:model="product_description" id="message" rows="11" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Leave a comment..."></textarea>
                    </div>
                    <input type="hidden" value="{{Auth::user()->pharmacy->id}}" wire:model="pharmacy_id">
                </div>
                <button type="submit" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Submit</button>
            </form>
        </div>
    </div><br><br>
    {{--?End the main content--}}
</div>
@endrole