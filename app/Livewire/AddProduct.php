<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;
use Livewire\WithFileUploads;

class AddProduct extends Component
{
    use WithFileUploads;
    public $product_name, $product_file, $product_price,
    $product_description, $quantity, $category_id, $pharmacy_id;
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
        $data = $this->validate([
            'product_name' => 'required|string|max:255',
            'product_price' => 'required|numeric|min:0',
            'product_description' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'product_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        Product::create([
            'product_name' => $this->product_name,
            'product_price' => $this->product_price,
            'product_description' => $this->product_description,
            'quantity' => $this->quantity,
            'category_id' => $this->category_id,
            'pharmacy_id' => $this->pharmacy_id,
            'product_file' => $this->product_file->store('product_files', 'public'),
        ]);

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
}
