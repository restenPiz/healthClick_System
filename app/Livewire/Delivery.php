<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Delivery extends Component
{
    use WithPagination;
    public function render()
    {
        $deliveries = \App\Models\Sale::whereHas('sale.product.pharmacy', function ($query) {
            $query->where('user_id', Auth::id());
        })
            // ->with(['product', 'product.category'])
            ->paginate(5);

        return view('livewire.delivery', compact('deliveries'))
            ->layout('layouts.app');
    }
}
