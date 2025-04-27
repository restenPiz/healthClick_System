<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Delivery;

class PharmacyDashboard extends Component
{
    public $productCount;
    public $saleCount;
    public $deliveryStats = [];

    public function mount()
    {
        $userId = Auth::id();

        // Corrigido: relacionando com o modelo da farmácia
        $this->productCount = Product::whereHas('pharmacy', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        // Já estava correto
        $this->saleCount = Sale::whereHas('product.pharmacy', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->count();

        $this->deliveryStats = [
            'pendente' => Delivery::whereHas('sale.product.pharmacy', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('status', 'pendente')->count(),

            'entregue' => Delivery::whereHas('sale.product.pharmacy', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })->where('status', 'entregue')->count(),
        ];
    }
    public function render()
    {
        return view('livewire.pharmacy-dashboard')
            ->layout('layouts.app');
    }
}
