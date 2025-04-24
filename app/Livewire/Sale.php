<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Sale extends Component
{
    // public $sales;
    use WithPagination;
    public $id, $sale, $selectedSaleId;
    public function render()
    {
        $sales = \App\Models\Sale::whereHas('product.pharmacy', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->with(['product', 'product.category'])
            ->paginate(5);

        return view('livewire.sale', compact('sales'))
            ->layout('layouts.app');
    }
    public function confirmDeletion($id)
    {
        $this->selectedSaleId = $id;
    }
    public function deleteSale()
    {
        $sale = \App\Models\Sale::find($this->selectedSaleId);
        $sale->delete();

        $this->reset('id');
        $this->dispatch('close-modal', 'confirm-user-deletion');
        $this->dispatch('sale-deleted');
    }
}
