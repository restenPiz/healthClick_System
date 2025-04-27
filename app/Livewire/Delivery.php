<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Delivery extends Component
{
    use WithPagination;

    public $status = '';

    public function render()
    {
        $query = \App\Models\Delivery::whereHas('sale.product.pharmacy', function ($query) {
            $query->where('user_id', Auth::id());
        });

        if ($this->status !== '') {
            $query->where('status', $this->status);
        }

        $deliveries = $query->paginate(5);

        return view('livewire.delivery', compact('deliveries'))
            ->layout('layouts.app');
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function filter()
    {
        $this->resetPage();
    }

    public function confirmDelivery($deliveryId)
    {
        $delivery = \App\Models\Delivery::findOrFail($deliveryId);
        $delivery->status = 'entregue';
        $delivery->save();
        $this->dispatch('delivery-updated');
    }
}