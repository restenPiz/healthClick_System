<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AddDelivery extends Component
{
    public $username, $email, $password;
    public function render()
    {
        return view('livewire.add-delivery')
            ->layout('layouts.app');
    }
    public function store()
    {
        $data = $this->validate([
            //?User Data
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
        ]);

        $user = \App\Models\User::create([
            'email' => $data['email'],
            'name' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        $user->addRole('delivery');

        $this->reset([
            'username',
            'email',
            'password',
        ]);

        $this->dispatch('delivery-added');
    }
}
