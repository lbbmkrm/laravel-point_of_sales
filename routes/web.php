<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'landing.index')->name('home');

Route::middleware('guest')->group(function () {
    Volt::route('/login', 'auth.login')->name('login');
    Volt::route('/register', 'auth.register')->name('register');
});

Route::middleware('auth')->group(function () {
    Volt::route('/dashboard', 'dashboard.home')->name('dashboard');
    Volt::route('/products', 'dashboard.product')->name('products');
    Volt::route('/cashier', 'dashboard.cashier')->name('cashier');
});
