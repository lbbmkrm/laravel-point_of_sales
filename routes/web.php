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
    Volt::route('/history', 'dashboard.history')->name('history');

    // Owner only routes
    Route::middleware('role:owner')->group(function () {
        Volt::route('/reports', 'dashboard.report')->name('reports');
        Volt::route('/users', 'dashboard.user')->name('users');
        Volt::route('/testimonials', 'dashboard.testimonial')->name('testimonials');
        Volt::route('/settings', 'dashboard.settings')->name('settings');
        Volt::route('/galleries', 'dashboard.gallery')->name('galleries');
    });
});
