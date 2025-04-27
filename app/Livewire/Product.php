<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Events\ProductUpdated;
use Livewire\WithPagination;

class Product extends Component
{
    use WithFileUploads, WithPagination;
    public $product, $selectedProductId, $id, $pharmacy_id, $product_file;
    public $product_name, $product_price, $category_id, $quantity, $product_description;

    public function mount()
    {
        $this->pharmacy_id = auth()->user()->pharmacy->id ?? null;
    }
    public function render()
    {
        if (Auth::user()->hasRole('pharmacy')) {
            $products = \App\Models\Product::where('pharmacy_id', $this->pharmacy_id)->paginate(3);
            $categories = \App\Models\Category::all();
            return view('livewire.product', compact('products', 'categories'))
                ->layout('layouts.app');
        } else {
            $products = \App\Models\Product::paginate(3);
            $categories = \App\Models\Category::all();
            return view('livewire.product', compact('products', 'categories'))
                ->layout('layouts.app');
        }
    }
    public function deleteProduct()
    {
        $product = \App\Models\Product::find($this->selectedProductId);
        $product->delete();

        event(new ProductUpdated($product));

        $this->reset('id');
        $this->dispatch('close-modal', 'confirm-user-deletion');
        $this->dispatch('product-deleted');
    }
    //?Method to open the modal
    public function confirmDeletion($id)
    {
        $this->selectedProductId = $id;
    }
    public $editProduct = [
        'id' => '',
        'product_name' => '',
        'product_price' => '',
        'quantity' => '',
        'category_id' => '',
        'pharmacy_id' => '',
        'product_description' => '',
        'product_file' => null,
    ];
    public function setProductToEdit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $this->editProduct = [
            'id' => $product->id,
            'product_name' => $product->product_name,
            'product_price' => $product->product_price,
            'quantity' => $product->quantity,
            'category_id' => $product->category_id,
            'pharmacy_id' => $product->pharmacy_id,
            'product_description' => $product->product_description,
            'product_file' => null,
        ];
    }
    public function updateProduct()
    {
        $this->validate([
            'editProduct.product_name' => 'required|string|max:255',
            'editProduct.product_price' => 'required|numeric|min:0',
            'editProduct.product_description' => 'required|string|max:255',
            'editProduct.quantity' => 'required|integer|min:0',
            'editProduct.category_id' => 'required|exists:categories,id',
            'editProduct.pharmacy_id' => 'required|exists:pharmacies,id',
            'product_file' => 'required',
        ]);

        $product = \App\Models\Product::findOrFail($this->editProduct['id']);

        // Verifica se tem ficheiro novo
        if ($this->product_file) {
            $path = $this->product_file->store('product_files', 'public');
            $this->editProduct['product_file'] = $path;
        } else {
            $this->editProduct['product_file'] = $product->product_file; // mantém o anterior
        }

        $product->update([
            'product_name' => $this->editProduct['product_name'],
            'product_price' => $this->editProduct['product_price'],
            'quantity' => $this->editProduct['quantity'],
            'category_id' => $this->editProduct['category_id'],
            'pharmacy_id' => $this->editProduct['pharmacy_id'],
            'product_description' => $this->editProduct['product_description'],
            'product_file' => $this->editProduct['product_file'],
        ]);

        event(new ProductUpdated($product));

        $this->reset('editProduct', 'product_file', 'product_description');
        $this->dispatch('close-modal', 'edit-pharmacy-modal');
        $this->dispatch('product-updated');
    }
}
