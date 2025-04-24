<?php

use App\Livewire\AddProduct;
use App\Livewire\Categories;
use App\Livewire\Dashboard;
use App\Livewire\PaymentMethods;
use App\Livewire\Pharmacy;
use App\Livewire\PharmacyDashboard;
use App\Livewire\PharmacyDetails;
use App\Livewire\Product;
use App\Livewire\Sale;
use App\Livewire\User;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'pages.auth.login')
    ->name('login');

Route::get('dashboard', function () {
    if (Auth::check()) {
        if (Auth::user()->hasRole('admin')) {
            return redirect()->route('dash');
        } elseif (Auth::user()->hasRole('pharmacy')) {
            return redirect()->route('pharmacyDashboard');
        }
    }

    return redirect()->route('login');
})->name('dashboard');

Route::get('/dash', Dashboard::class)->name('dash');
Route::get('pharmacyDashboard', PharmacyDashboard::class)->name('pharmacyDashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name(name: 'profile');

//*Pharmacy routes
Route::get('/pharmacy', Pharmacy::class)->name('pharmacy');
Route::get('/pharmacyDetails/{id}', PharmacyDetails::class)->name('pharmacyDetails');

//*Category route
Route::get('/category', Categories::class)->name('category');

Route::get('/addProduct', AddProduct::class)->name('addProduct');
Route::get('/product', Product::class)->name('product');
Route::get('/user', User::class)->name('user');
Route::get('/payment_methods', PaymentMethods::class)->name('payment_methods');

//*Sale Route
Route::get('/Sale', Sale::class)->name('sale');

require __DIR__.'/auth.php';
