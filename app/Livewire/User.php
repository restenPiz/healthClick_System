<?php

namespace App\Livewire;

use Livewire\Component;

class User extends Component
{
    public function render()
    {
        $users = \App\Models\User::where('id', '>', 1)->paginate(4);
        return view('livewire.user', compact('users'))
            ->layout('layouts.app');
    }
}
