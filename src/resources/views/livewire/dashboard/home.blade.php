<?php

use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{layout, title};

title('Dashboard');

// Action logout — closure biasa sudah otomatis jadi public method
$logout = function (): void {
    Auth::logout();
    $this->redirect('/', navigate: true);
};
?>

<div class="p-6">
    <h1 class="text-2xl font-semibold">Welcome, {{ auth()->user()->name }}</h1>
    <p class="mt-2">You're logged in!</p>
    <button wire:click="logout" class="bg-red-500 text-white px-4 py-2 rounded-md">
        Logout
    </button>
</div>
