<?php

namespace App\Livewire;

use Livewire\Component;

class Product extends Component
{
    public function mount()
    {
        $this->pharmacy_id = auth()->user()->pharmacy->id ?? null;
    }
    public function render()
    {
        $products = \App\Models\Product::where('pharmacy_id', $this->pharmacy_id)->get();
        return view('livewire.product', compact('products'))
            ->layout('layouts.app');
    }
}
