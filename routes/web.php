<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'landing.index')->name('home');

Route::middleware('guest')->group(function () {
    Volt::route('/login', 'auth.login')->name('login');
});

Route::middleware('auth')->group(function () {
    Volt::route('/dashboard', 'dashboard.home')->name('dashboard');
    Volt::route('/products', 'dashboard.product')->name('products');
    Volt::route('/cashier', 'dashboard.cashier')->name('cashier');
    Volt::route('/reports', 'dashboard.report')->name('reports');
});
