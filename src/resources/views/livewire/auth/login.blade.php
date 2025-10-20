<?php

use Livewire\Volt\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

new
#[Layout('layouts.guest')]
#[Title('Login')]
class extends Component
{
    public static string $title = 'Login';

    public string $username = '';
    public string $password = '';
    public bool $remember = false;

    protected array $rules = [
        'username' => 'required|string',
        'password' => 'required|min:6',
    ];

    public function login(): void
    {
        $this->validate();

        if (!Auth::attempt([
            'username' => $this->username,
            'password' => $this->password,
        ], $this->remember)) {
            throw ValidationException::withMessages([
                'username' => __('Username atau password tidak valid.'),
            ]);
        }

        session()->regenerate();

        $this->redirect('/', navigate: true);
    }
};
?>

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-sm bg-white rounded-2xl shadow-md p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-semibold">QIO Coffee</h1>
        </div>

        <form wire:submit="login" class="space-y-4">
            <div>
                <label for="username" class="block mb-2 text-sm font-medium text-gray-900">
                    Username
                </label>
                <input
                    wire:model.blur="username"
                    id="username"
                    type="text"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                    placeholder="Masukkan username Anda"
                    autofocus
                >
                @error('username')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">
                    Password
                </label>
                <input
                    wire:model.blur="password"
                    id="password"
                    type="password"
                    class="shadow-xs bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                >
                @error('password')
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex items-center">
                <input
                    wire:model="remember"
                    id="remember"
                    type="checkbox"
                    class="w-4 h-4 border border-gray-300 rounded-sm bg-gray-50 focus:ring-3 focus:ring-blue-300"
                >
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    Ingat saya
                </label>
            </div>

            <button
                type="submit"
                wire:loading.attr="disabled"
                wire:target="login"
                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center disabled:opacity-50 disabled:cursor-not-allowed"
            >
                <span wire:loading.remove wire:target="login">Masuk</span>
                <span wire:loading wire:target="login">Memproses...</span>
            </button>

            <p class="mt-2 text-sm text-gray-500 text-center">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-medium text-blue-600 hover:underline">
                    Daftar disini
                </a>
            </p>
        </form>
    </div>
</div>
