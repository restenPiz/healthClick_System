<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class AddProduct extends Component
{
    public function render()
    {
        $categories = Category::all();
        return view('livewire.add-product', compact('categories'))
            ->layout('layouts.app');
    }
}
