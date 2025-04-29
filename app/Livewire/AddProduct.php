<?php

namespace App\Livewire;

use App\Events\ProductUpdated;
use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddProduct extends Component
{
    use WithFileUploads;
    public $product_name, $product_file, $product_price,
    $product_description, $quantity, $category_id, $pharmacy_id;
    public $product;
    public function mount()
    {
        $this->pharmacy_id = auth()->user()->pharmacy->id ?? null;
    }

    public function render()
    {
        $categories = Category::all();
        $products = Product::where('pharmacy_id', $this->pharmacy_id)->get();
        return view('livewire.add-product', compact('categories', 'products'))
            ->layout('layouts.app');
    }
    public function save()
    {
        // dd($this->all());
        $this->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            // 'category_id' => 'required|exists:categories,id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'product_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($this->product_file) {
            $filePath = $this->product_file->store('product_files', 'public');
        } else {
            $filePath = null;
        }

        Product::create([
            'product_name' => $this->product_name,
            'product_price' => $this->product_price,
            'product_description' => $this->product_description,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'pharmacy_id' => $this->pharmacy_id,
            // 'product_file' => $this->product_file->store('product_files', 'public'),
            'product_file' => $filePath,
        ]);

        // event(new ProductUpdated($product));

        $this->reset([
            'product_name',
            'product_price',
            'product_description',
            'quantity',
            'category_id',
            'pharmacy_id',
            'product_file',
        ]);
        $this->dispatch('product-added');
    }
    // public function save()
    // {
    //     // Adicione logging para depuração
    //     \Log::info('Starting product save...');
    //     \Log::info('File info:', ['file' => $this->product_file ? get_class($this->product_file) : 'No file']);

    //     $this->validate([
    //         'product_name' => 'required|string|max:255',
    //         'product_price' => 'required|numeric|min:0',
    //         'product_description' => 'required|string|max:255',
    //         'quantity' => 'required|integer|min:0',
    //         'category_id' => 'required|exists:categories,id', // Descomentei esta linha para validar a categoria
    //         'pharmacy_id' => 'required|exists:pharmacies,id',
    //         'product_file' => 'nullable|image|max:2048', // Mudei para 'image' para validar qualquer tipo de imagem
    //     ]);

    //     $filePath = null;

    //     if ($this->product_file) {
    //         try {
    //             // Obter informações do arquivo para logging
    //             \Log::info('File details before upload:', [
    //                 'name' => $this->product_file->getClientOriginalName(),
    //                 'mime' => $this->product_file->getMimeType(),
    //                 'size' => $this->product_file->getSize(),
    //                 'extension' => $this->product_file->getClientOriginalExtension()
    //             ]);

    //             // Gerar um nome de arquivo mais limpo
    //             $extension = $this->product_file->getClientOriginalExtension();
    //             $filename = time() . '_' . uniqid() . '.' . $extension;

    //             // Salvar o arquivo usando storeAs
    //             $filePath = $this->product_file->storeAs('product_files', $filename, 'public');

    //             \Log::info('File stored successfully', ['path' => $filePath]);

    //         } catch (\Exception $e) {
    //             \Log::error('Error uploading file: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //             session()->flash('error', 'Failed to upload image: ' . $e->getMessage());
    //             $filePath = null;
    //         }
    //     }

    //     try {
    //         // Cria o produto
    //         $product = Product::create([
    //             'product_name' => $this->product_name,
    //             'product_price' => $this->product_price,
    //             'product_description' => $this->product_description,
    //             'quantity' => $this->quantity,
    //             'category_id' => $this->category_id,
    //             'pharmacy_id' => $this->pharmacy_id,
    //             'product_file' => $filePath,
    //         ]);

    //         \Log::info('Product created successfully', ['product_id' => $product->id]);

    //         // Limpa os campos do formulário
    //         $this->reset([
    //             'product_name',
    //             'product_price',
    //             'product_description',
    //             'quantity',
    //             'category_id',
    //             'product_file',
    //         ]);

    //         // Não resetamos pharmacy_id pois é definido no mount

    //         $this->dispatch('product-added');
    //         session()->flash('success', 'Product added successfully!');

    //     } catch (\Exception $e) {
    //         \Log::error('Error creating product: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
    //         session()->flash('error', 'Failed to create product: ' . $e->getMessage());
    //     }
    // }
}
