<?php

namespace App\Livewire;

use Livewire\Component;

class Sale extends Component
{
    public function render()
    {
        return view('livewire.sale')
            ->layout('layouts.app');
    }
}
