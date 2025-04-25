<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Delivery extends Component
{
    use WithPagination;
    // public $deliveries;
    public function render()
    {
        $deliveries = \App\Models\Delivery::whereHas('sale.product.pharmacy', function ($query) {
            $query->where('user_id', Auth::id());
        })
            // ->with(['sale', 'sale.user'])
            ->paginate(5);

        return view('livewire.delivery', compact('deliveries'))
            ->layout('layouts.app');
    }
    public function confirmDelivery($deliveryId)
    {
        $delivery = \App\Models\Delivery::findOrFail($deliveryId);
        $delivery->status = 'entregue'; // ou 'sucesso'
        $delivery->save();
        $this->dispatch('delivery-updated');
    }
}
