<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pharmacy;

class PharmacyDetails extends Component
{
    public $pharmacy;

    public function mount($id)
    {
        $this->pharmacy = Pharmacy::with('user')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.pharmacy-details')
            ->layout('layouts.app');
    }
}
