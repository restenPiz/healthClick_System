<?php

namespace App\Livewire;

use Livewire\Component;

class PaymentMethods extends Component
{
    public function render()
    {
        return view('livewire.payment-methods')
            ->layout('layouts.app');
    }
}
