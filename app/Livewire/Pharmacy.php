<?php

namespace App\Livewire;

use Livewire\Component;

class Pharmacy extends Component
{
    public function render()
    {
        $pharmacies = Pharmacy::all();
        return view('livewire.pharmacy', compact('pharmacies'))
            ->layout('layouts.app');
    }
}
