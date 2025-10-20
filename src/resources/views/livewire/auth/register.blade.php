<?php

use App\Livewire\Forms\RegisterForm;
use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;


new
#[Layout('layouts.guest')]
class extends Component
{
    public static string $title = 'Register';

    public RegisterForm $form;

    public function register(AuthService $authService): void
    {
        $validated = $this->form->validate();

        $user = $authService->register($validated);

        Auth::login($user);

        session()->regenerate();

        $this->redirect('/', navigate: true);
    }
};

?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-semibold">Buat Akun Baru</h1>
        </div>

        <form wire:submit="register" class="space-y-4">
            <div>
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">
                    Nama
                </label>
                <input
                    wire:model.blur="form.name"
                    id="name"
                    type="text"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Nama Lengkap"
                    autofocus
                >
                @error('form.name')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900">
                    Username
                </label>
                <input
                    wire:model.blur="form.username"
                    id="username"
                    type="text"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Username"
                >
                @error('form.username')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">
                    No. Telepon (Opsional)
                </label>
                <input
                    wire:model.blur="form.phone"
                    id="phone"
                    type="tel"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="08123456789"
                >
                @error('form.phone')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                    Password
                </label>
                <input
                    wire:model.blur="form.password"
                    id="password"
                    type="password"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                >
                @error('form.password')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900">
                    Konfirmasi Password
                </label>
                <input
                    wire:model.blur="form.password_confirmation"
                    id="password_confirmation"
                    type="password"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                >
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="register"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span wire:loading.remove wire:target="register">Daftar</span>
                <span wire:loading wire:target="register">Memproses...</span>
            </button>

            <p class="mt-2 text-sm text-gray-500 text-center">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">
                    Masuk disini
                </a>
            </p>
        </form>
    </div>
</div>