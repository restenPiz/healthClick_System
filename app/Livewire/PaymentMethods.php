<?php

namespace App\Livewire;

use App\Models\Payment;
use Livewire\Component;

class PaymentMethods extends Component
{
    public $method_name;
    public function render()
    {
        return view('livewire.payment-methods')
            ->layout('layouts.app');
    }
    public function save()
    {
        $data = $this->validate([
            //?User Data
            'method_name' => 'required|string|max:255',
        ]);

        $payment = new Payment();

        $payment->method_name = $this->input('method_name');

        $payment->store();

        $this->dispatch('pharmacy-updated');
    }
}
