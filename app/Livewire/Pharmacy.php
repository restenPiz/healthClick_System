<?php

namespace App\Livewire;

use App\Models\User;
use DB;
use Hash;
use Livewire\Component;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class Pharmacy extends Component
{
    //?Pharmacy Datas
    public $id, $pharmacy, $user_id, $pharmacy_name, $pharmacy_location, $pharmacy_description;
    public $name, $email, $password, $data;
    public $showModal = false;

    protected $listeners = ['openModal' => 'openModal'];

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }
    public function render()
    {
        $pharmacies = Pharmacy::all();
        return view('livewire.pharmacy', compact('pharmacies'))
            ->layout('layouts.app');
    }
    public function save()
    {
        $data = $this->validate([
            //?User Data
            'email' => 'required|email|max:255',
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6|max:255',
            //?Pharmacy Data
            'pharmacy_name' => 'required|string|max:255',
            'pharmacy_location' => 'required|string|max:255',
            'pharmacy_description' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
            ]);
            $user->addRole('pharmacy');

            \App\Models\Pharmacy::create([
                'pharmacy_name' => $data['pharmacy_name'],
                'pharmacy_location' => $data['pharmacy_location'],
                'pharmacy_description' => $data['pharmacy_description'],
                'user_id' => $user->id,
            ]);
        });

        $this->reset([
            'name',
            'email',
            'password',
            'pharmacy_name',
            'pharmacy_location',
            'pharmacy_description',
        ]);

        $this->showModal = false;

        $this->dispatch('close-modal');

        toast('Pharmacy added with successfuly', 'success');
    }
    public function destroy($id)
    {
        $pharmacy = Pharmacy::findOrFail($id);

        $pharmacy->delete();
    }
}
