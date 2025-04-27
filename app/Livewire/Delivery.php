<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Delivery extends Component
{
    use WithPagination;
    // public $deliveries;
    public $status;
    public function render()
    {
        $query = \App\Models\Delivery::whereHas('sale.product.pharmacy', function ($query) {
            $query->where('user_id', Auth::id());
        });

        if (!empty($this->status)) {
            $query->where('status', $this->status);
        }

        $deliveries = $query->paginate(5); // <-- ESSENCIAL!

        return view('livewire.delivery', compact('deliveries'))
            ->layout('layouts.app');
    }
    public function updatedStatus()
    {
        $this->resetPage();
    }
    public function confirmDelivery($deliveryId)
    {
        $delivery = \App\Models\Delivery::findOrFail($deliveryId);
        $delivery->status = 'entregue'; // ou 'sucesso'
        $delivery->save();
        $this->dispatch('delivery-updated');
    }
}
