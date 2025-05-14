<?php

namespace App\Livewire;

use App\Models\User;
use DB;
use Hash;
use Livewire\Component;
use Livewire\WithFileUploads;
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
            // 'pharmacy_location' => 'required|string|max:255',
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
                // 'pharmacy_location' => $data['pharmacy_location'],
                'pharmacy_description' => $data['pharmacy_description'],
                'pharmacy_contact' => $data['pharmacy_contact'],
                'user_id' => $user->id,
            ];

            if ($this->pharmacy_file) {
                $path = $this->pharmacy_file->storeAs('pharmacy_files', 'public');
                $pharmacyData['pharmacy_file'] = $path;
            }

            \App\Models\Pharmacy::create($pharmacyData);
        });

        $this->reset([
            'name',
            'email',
            'password',
            'pharmacy_name',
            // 'pharmacy_location',
            'pharmacy_description',
            'pharmacy_contact',
            'pharmacy_file',
        ]);

        $this->dispatch('close-modal', 'add-pharmacy');

        $this->dispatch('pharmacy-added');
    }
    public function deletePharmacy()
    {
        $pharmacy = \App\Models\Pharmacy::find($this->selectedPharmacyId);

        if ($pharmacy) {
            $pharmacy->user()->delete();
            $pharmacy->delete();

            session()->flash('message', 'Farmácia eliminada com sucesso.');
        }

        $this->reset('selectedPharmacyId', 'pharmacy');
        $this->dispatch('close-modal', 'confirm-user-deletion');
        $this->dispatch('pharmacy-deleted');
    }
    public $editPharmacy = [
        'id' => null,
        'pharmacy_name' => '',
        // 'pharmacy_location' => '',
        'pharmacy_contact' => '',
        'pharmacy_file' => '',
    ];
    public function setPharmacyToEdit($id)
    {
        $pharmacy = \App\Models\Pharmacy::findOrFail($id);
        $this->editPharmacy = [
            'id' => $pharmacy->id,
            'pharmacy_name' => $pharmacy->pharmacy_name,
            // 'pharmacy_location' => $pharmacy->pharmacy_location,
            'pharmacy_contact' => $pharmacy->pharmacy_contact,
            'pharmacy_file' => $pharmacy->pharmacy_file,
        ];
    }


    public function updatePharmacy()
    {
        $this->validate([
            'editPharmacy.pharmacy_name' => 'required|string|max:255',
            // 'editPharmacy.pharmacy_location' => 'required|string|max:255',
            'editPharmacy.pharmacy_contact' => 'required|string|max:255',
            'editPharmacy.pharmacy_file' => 'nullable|image|max:1024', // Validação para imagem
        ]);

        $pharmacyData = [
            'pharmacy_name' => $this->editPharmacy['pharmacy_name'],
            'pharmacy_contact' => $this->editPharmacy['pharmacy_contact'],
        ];

        // Processa o upload da imagem se uma nova for fornecida
        if ($this->editPharmacy['pharmacy_file'] && !is_string($this->editPharmacy['pharmacy_file'])) {
            $pharmacyData['pharmacy_file'] = $this->editPharmacy['pharmacy_file']->store('pharmacy_files', 'public');
        }

        $pharmacy = \App\Models\Pharmacy::findOrFail($this->editPharmacy['id']);
        $pharmacy->update($pharmacyData);

        $this->reset([
            'pharmacy',
            'pharmacy_name',
            'pharmacy_contact',
            'pharmacy_location',
            'pharmacy_description',
            'pharmacy_contact',
            'pharmacy_file',
        ]);

        $this->dispatch('close-modal', 'edit-pharmacy-modal');
        $this->dispatch('pharmacy-updated');
    }

}
