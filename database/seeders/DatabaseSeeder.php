<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(LaratrustSeeder::class);

        $user = User::factory()->create([
            'name' => 'Mauro Peniel',
            'email' => 'admin@gmail.com',
            'password' => 'admin@123',
        ]);

        $user->addRole('admin');
    }
}
