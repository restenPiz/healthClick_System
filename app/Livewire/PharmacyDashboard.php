<?php

namespace App\Livewire;

use Livewire\Component;

class PharmacyDashboard extends Component
{
    public function render()
    {
        return view('livewire.pharmacy-dashboard')
            ->layout('layouts.app');
    }
}
