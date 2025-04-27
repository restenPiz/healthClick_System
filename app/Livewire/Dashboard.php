<?php

namespace App\Livewire;

use App\Models\Delivery;
use App\Models\Sale;
use App\Models\Product;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $product = Product::count();
        $sale = Sale::count();
        $deliveryP = Delivery::where('status', '=', 'pendente')->count();
        $deliveryD = Delivery::where('status', '=', 'entregue')->count();
        return view('livewire.dashboard', compact('product', 'sale', 'deliveryP', 'deliveryD'))
            ->layout('layouts.app');
    }
}
