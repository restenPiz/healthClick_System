<?php

namespace App\Livewire;

use Livewire\Component;

class User extends Component
{
    public function render()
    {
        return view('livewire.user')
            ->layout('layouts.app');
    }
}
