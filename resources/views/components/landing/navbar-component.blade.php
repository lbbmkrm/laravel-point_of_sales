@props([
    "shopProfile",
])

<nav
    x-data="{
        isOpen: false,
        scrolled: false,
        activeSection: 'home',
    }"
    @scroll.window="scrolled = (window.pageYOffset > 50)"
    :class="{ 'bg-stone-900/40 backdrop-blur-md shadow-lg': scrolled, 'bg-transparent': !scrolled }"
    class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="#" class="flex items-center space-x-3 group">
                    <div class="relative">
                        @if ($shopProfile->logo)
                            <img
                                src="{{ asset("storage/" . $shopProfile->logo) }}"
                                alt="{{ $shopProfile->name }}"
                                class="w-12 h-12 rounded-full object-cover"
                            />
                        @else
                            <svg
                                class="w-10 h-10 text-amber-500 relative z-10"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M18.5 2c1.38 0 2.5 1.12 2.5 2.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H8V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H4V4.5C4 3.12 5.12 2 6.5 2h12zM4 19c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8H4v11zm8-9c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z"
                                />
                            </svg>
                        @endif
                    </div>
                    <div>
                        <h1 class="text-xl font-Playfair font-bold text-white">
                            {{ $shopProfile->name }}
                        </h1>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-1">
                <a
                    href="#about"
                    class="px-4 py-2 text-white hover:text-amber-500 transition-colors duration-200 font-medium relative group"
                >
                    Tentang
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-500 group-hover:w-full transition-all duration-300"
                    ></span>
                </a>
                <a
                    href="#menu"
                    class="px-4 py-2 text-white hover:text-amber-500 transition-colors duration-200 font-medium relative group"
                >
                    Menu
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-500 group-hover:w-full transition-all duration-300"
                    ></span>
                </a>
                <a
                    href="#gallery"
                    class="px-4 py-2 text-white hover:text-amber-500 transition-colors duration-200 font-medium relative group"
                >
                    Galeri
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-500 group-hover:w-full transition-all duration-300"
                    ></span>
                </a>
                <a
                    href="#contact"
                    class="px-4 py-2 text-white hover:text-amber-500 transition-colors duration-200 font-medium relative group"
                >
                    Kontak
                    <span
                        class="absolute bottom-0 left-0 w-0 h-0.5 bg-amber-500 group-hover:w-full transition-all duration-300"
                    ></span>
                </a>
            </div>

            <!-- CTA Button Desktop -->
            <div class="hidden md:flex items-center">
                @auth
                    <a
                        href="{{ route("dashboard") }}"
                        wire:navigate
                        class="px-8 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2"
                    >
                        <i class="ri-dashboard-line text-lg"></i>
                        <span>Dashboard</span>
                    </a>
                @else
                    <a
                        href="{{ route("login") }}"
                        wire:navigate
                        class="px-8 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2"
                    >
                        <i class="ri-user-settings-line text-lg"></i>
                        <span>Login</span>
                    </a>
                @endauth
            </div>

            <!-- Mobile Menu Button -->
            <div class="md:hidden flex items-center">
                <button
                    @click="isOpen = !isOpen"
                    class="text-white hover:text-amber-500 focus:outline-none transition-colors"
                >
                    <svg
                        class="w-7 h-7"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            x-show="!isOpen"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"
                        ></path>
                        <path
                            x-show="isOpen"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="md:hidden bg-stone-900/98 backdrop-blur-lg border-t border-gray-800"
    >
        <div class="px-4 pt-4 pb-6 space-y-2">
            <a
                href="#about"
                @click="isOpen = false"
                class="block px-4 py-3 text-white hover:text-amber-500 hover:bg-white/5 rounded-lg transition-all duration-200 font-medium"
            >
                Tentang
            </a>
            <a
                href="#menu"
                @click="isOpen = false"
                class="block px-4 py-3 text-white hover:text-amber-500 hover:bg-white/5 rounded-lg transition-all duration-200 font-medium"
            >
                Menu
            </a>
            <a
                href="#gallery"
                @click="isOpen = false"
                class="block px-4 py-3 text-white hover:text-amber-500 hover:bg-white/5 rounded-lg transition-all duration-200 font-medium"
            >
                Galeri
            </a>
            <a
                href="#contact"
                @click="isOpen = false"
                class="block px-4 py-3 text-white hover:text-amber-500 hover:bg-white/5 rounded-lg transition-all duration-200 font-medium"
            >
                Kontak
            </a>

            @auth
                <a
                    href="{{ route("dashboard") }}"
                    wire:navigate
                    class="block px-4 py-3 text-white hover:text-amber-500 hover:bg-white/5 rounded-lg transition-all duration-200 font-medium"
                >
                    Dashboard
                </a>
            @else
                <a
                    href="{{ route("login") }}"
                    wire:navigate
                    class="block px-4 py-3 text-white hover:text-amber-500 hover:bg-white/5 rounded-lg transition-all duration-200 font-medium"
                >
                    Login
                </a>
            @endauth
        </div>
    </div>
</nav>
