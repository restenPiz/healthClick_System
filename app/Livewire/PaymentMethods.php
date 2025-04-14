<?php

namespace App\Livewire;

use App\Models\PaymentMethod;
use Livewire\Component;

class PaymentMethods extends Component
{
    public $method_name, $id, $payment, $selectedPaymentId;
    public function render()
    {
        return view('livewire.payment-methods', [
            'payments' => PaymentMethod::all()
        ])->layout('layouts.app');
    }
    public function save()
    {
        // dd($this->all());
        $data = $this->validate([
            //?User Data
            'method_name' => 'required|string|max:255',
        ]);

        PaymentMethod::create([
            'method_name' => $this->method_name,
        ]);

        $this->reset([
            'method_name',
        ]);

        $this->dispatch('payment-added');
    }
    public function deletePayment()
    {
        $payment = PaymentMethod::find($this->selectedPaymentId);
        $payment->delete();

        $this->reset('id', 'method_name');
        $this->dispatch('close-modal', 'confirm-user-deletion');
        $this->dispatch('payment-deleted');
    }
    //?Method to open the modal
    public function confirmDeletion($id)
    {
        $this->selectedPaymentId = $id;
    }
    //?Method to open de edit modal
    public $editPayment = [
        'id' => null,
        'method_name' => '',
    ];
    public function setPaymentToEdit($id)
    {
        $payment = PaymentMethod::findOrFail($id);
        $this->editPayment = [
            'id' => $payment->id,
            'method_name' => $payment->method_name,
        ];
    }
    public function updatePayment()
    {
        $this->validate([
            'editPayment.method_name' => 'required|string|max:255',
        ]);

        $payment = PaymentMethod::findOrFail($this->editPayment['id']);
        $payment->update($this->editPayment);

        $this->reset([
            'method_name',
            'id',
        ]);

        $this->dispatch('close-modal', 'edit-pharmacy-modal');
        $this->dispatch('payment-updated');
    }
}
