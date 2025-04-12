<?php

use App\Livewire\Dashboard;
use App\Livewire\PaymentMethods;
use App\Livewire\Pharmacy;
use App\Livewire\PharmacyDetails;
use App\Livewire\Product;
use App\Livewire\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'pages.auth.login')
    ->name('login');

Route::get('dashboard', Dashboard::class)->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name(name: 'profile');

//*Pharmacy routes
Route::get('/pharmacy', Pharmacy::class)->name('pharmacy');
Route::get('/pharmacyDetails/{id}', PharmacyDetails::class)->name('pharmacyDetails');

Route::get('/product', Product::class)->name('product');
Route::get('/user', User::class)->name('user');
Route::get('/payment_methods', PaymentMethods::class)->name('payment_methods');

require __DIR__.'/auth.php';
