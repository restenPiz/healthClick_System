<?php

namespace App\Livewire;

use App\Models\User;
use DB;
use Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class Pharmacy extends Component
{
    use WithFileUploads;
    //?Pharmacy Datas
    public $id, $pharmacy, $user_id, $pharmacy_name, $pharmacy_location, $pharmacy_description;
    public $name, $email, $password, $data;
    public $pharmacy_contact, $pharmacy_file, $pharmacy_data;
    public $selectedPharmacyId;

    public function render()
    {
        return view('livewire.pharmacy', [
            'pharmacies' => \App\Models\Pharmacy::with('user')->get()
        ])->layout('layouts.app');
    }
    public function confirmDeletion($id)
    {
        $this->selectedPharmacyId = $id;
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
            'pharmacy_contact' => 'required|string|max:255',
            'pharmacy_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'email' => $data['email'],
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
            ]);
            $user->addRole('pharmacy');

            $pharmacyData = [
                'pharmacy_name' => $data['pharmacy_name'],
                'pharmacy_location' => $data['pharmacy_location'],
                'pharmacy_description' => $data['pharmacy_description'],
                'pharmacy_contact' => $data['pharmacy_contact'],
                'user_id' => $user->id,
            ];

            if ($this->pharmacy_file) {
                $path = $this->pharmacy_file->store('pharmacy_files', 'public');
                $pharmacyData['pharmacy_file'] = $path;
            }

            \App\Models\Pharmacy::create($pharmacyData);
        });

        $this->reset([
            'name',
            'email',
            'password',
            'pharmacy_name',
            'pharmacy_location',
            'pharmacy_description',
            'pharmacy_contact',
            'pharmacy_file',
        ]);

        $this->dispatch('close-modal', 'add-pharmacy');

        toast('Pharmacy added with successfuly', 'success');
    }
    public function deletePharmacy()
    {
        $pharmacy = \App\Models\Pharmacy::find($this->selectedPharmacyId);

        if ($pharmacy) {
            // Opcional: deletar também o usuário associado, se quiser
            $pharmacy->user()->delete();
            $pharmacy->delete();

            session()->flash('message', 'Farmácia eliminada com sucesso.');
        }

        $this->reset('selectedPharmacyId');
        $this->dispatch('close-modal', 'confirm-user-deletion');
    }
}
