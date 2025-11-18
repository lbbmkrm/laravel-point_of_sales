<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public bool $dropdownOpen = false;

    public function toggleDropdown()
    {
        $this->dropdownOpen = ! $this->dropdownOpen;
    }

    public function closeDropdown()
    {
        $this->dropdownOpen = false;
    }

    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        $this->redirect("/login", navigate: true);
    }
}; ?>

<nav class="fixed top-0 z-50 w-full md:py-2 bg-white border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Left Section: Menu Button & Logo -->
            <div class="flex items-center gap-3 sm:gap-4">
                <button
                    x-on:click="isSidebarOpen = !isSidebarOpen"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-amber-500 transition-colors duration-200 lg:hidden"
                    aria-label="Toggle menu"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        ></path>
                    </svg>
                </button>

                <a href="#" class="flex items-center gap-2.5 group">
                    <!-- Logo QIA -->
                    <div
                        class="flex items-center justify-center w-10 h-10 bg-gradient-to-br from-amber-500 to-amber-600 rounded-lg shadow-md group-hover:shadow-lg transition-all duration-200"
                    >
                        <span class="text-white font-bold text-xl">Q</span>
                    </div>
                    <span
                        class="text-xl font-bold text-gray-900 sm:text-2xl group-hover:text-amber-600 transition-colors duration-200"
                    >
                        QIA
                    </span>
                </a>
            </div>

            <!-- Right Section: User Profile with Dropdown -->
            <div
                class="relative"
                x-data="{ open: @entangle("dropdownOpen") }"
                @click.away="open = false"
            >
                <button
                    x-on:click="open = !open"
                    class="relative cursor-pointer flex items-center justify-center w-10 h-10 rounded-full bg-gray-200 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500 transition-all duration-200"
                    aria-label="User menu"
                    aria-expanded="false"
                    aria-haspopup="true"
                >
                    <!-- User Icon -->
                    <svg
                        class="w-6 h-6 text-gray-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        ></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div
                    x-show="open"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                    role="menu"
                    aria-orientation="vertical"
                    style="display: none"
                >
                    <!-- User Info Section -->
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-medium text-gray-900">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 mt-0.5">
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <!-- Menu Items -->
                    <div class="py-1">
                        <a
                            href="#"
                            class="cursor-pointer group flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150"
                        >
                            <svg
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                ></path>
                            </svg>
                            Your Profile
                        </a>

                        <a
                            href="{{ route("settings") }}"
                            wire:navigate
                            class="cursor-pointer group flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-150"
                        >
                            <svg
                                class="mr-3 h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                ></path>
                            </svg>
                            Settings
                        </a>
                    </div>

                    <!-- Logout Section -->
                    <div class="py-1 border-t border-gray-100">
                        <button
                            wire:click="logout"
                            class="cursor-pointer group flex items-center w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 transition-colors duration-150"
                        >
                            <svg
                                class="mr-3 h-5 w-5 text-red-500 group-hover:text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"
                                ></path>
                            </svg>
                            Sign Out
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
