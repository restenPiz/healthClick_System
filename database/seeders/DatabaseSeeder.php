<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        // \App\Models\User::factory(10)->create();
        $user = User::create([
            'name' => 'Mauro Peniel',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
        ]);
        $user->addRole('admin');
    }
}
