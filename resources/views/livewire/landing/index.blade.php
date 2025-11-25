<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\ShopProfile;
use App\Services\ShopProfileService;
use App\Services\ProductService;
use App\Services\CategoryService;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout};
use Illuminate\Database\Eloquent\Collection;

new #[Layout("layouts.landing")] class extends Component {
    public ShopProfile $shopProfile;
    public Collection $products;
    public Collection $categories;
    public ?string $selectedCategory = null;

    public function mount(
        ShopProfileService $shopProfileService,
        ProductService $productService,
        CategoryService $categoryService,
    ): void {
        $this->shopProfile = $shopProfileService->getShopProfile();
        $this->products = $productService->getAllProducts();
        $this->categories = $categoryService->getAllCategories();
    }

    public function filterByCategory(
        ProductService $productService,
        ?string $categoryName = null,
    ): void {
        $this->selectedCategory = $categoryName;
        $this->products = $productService->getAllProducts(
            $this->selectedCategory,
        );
    }
}; ?>

<div class="min-h-screen font-Montserrat text-primary-text">
    <!-- Navigation Header -->
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
                            <div
                                class="absolute inset-0 bg-amber-500 rounded-full blur-md opacity-50 group-hover:opacity-75 transition-opacity"
                            ></div>
                            <svg
                                class="w-10 h-10 text-amber-500 relative z-10"
                                fill="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    d="M18.5 2c1.38 0 2.5 1.12 2.5 2.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H8V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H4V4.5C4 3.12 5.12 2 6.5 2h12zM4 19c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V8H4v11zm8-9c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5-1.5-.67-1.5-1.5.67-1.5 1.5-1.5z"
                                />
                            </svg>
                        </div>
                        <div>
                            <h1
                                class="text-xl font-Playfair font-bold text-white"
                            >
                                {{ $this->shopProfile->name }}
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
                </div>

                <!-- CTA Button Desktop -->
                <div class="hidden md:flex items-center space-x-4">
                    <a
                        href="#menu"
                        class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center space-x-2"
                    >
                        <svg
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                            ></path>
                        </svg>
                        <span>Order Now</span>
                    </a>
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
                <div class="pt-4">
                    <a
                        href="#menu"
                        @click="isOpen = false"
                        class="block w-full px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition-all duration-300 text-center shadow-lg"
                    >
                        Order Now
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <main id="home">
        <!-- Hero Section -->
        <section
            class="relative min-h-screen flex items-center justify-center overflow-hidden px-8"
            x-data="{}"
            @scroll.window="let scrollPosition = window.pageYOffset; if (scrollPosition < window.innerHeight) { $refs.heroImage.style.transform = `scale(1.2) translateY(${scrollPosition * 0.3}px)`; }"
        >
            <!-- Background Grid Photos with Overlay -->
            <div class="absolute inset-0 z-0">
                <!-- Dark Overlay -->
                <div class="absolute inset-0 bg-black/60 z-10"></div>

                <!-- Single Background Image -->
                <img
                    x-ref="heroImage"
                    src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?q=80&w=1920"
                    alt="Secangkir kopi sebagai latar belakang"
                    class="w-full h-full object-cover transition-transform duration-75 ease-out"
                    style="transform: scale(1.2)"
                />
            </div>

            <!-- Hero Content -->
            <div class="relative z-20 text-center max-w-4xl mx-auto">
                <div class="mb-6">
                    <h1
                        class="text-6xl md:text-8xl font-Playfair font-bold text-white mb-4 tracking-wide"
                    >
                        Welcome
                    </h1>
                    <div class="w-24 h-1 bg-amber-500 mx-auto mb-8"></div>
                </div>

                <p class="text-xl md:text-2xl text-gray-200 mb-4 font-light">
                    to Our Street Coffee
                </p>

                <p
                    class="text-base md:text-lg text-gray-300 mb-12 max-w-2xl mx-auto leading-relaxed"
                >
                    {{ $this->shopProfile->landing_description }}
                </p>

                <div
                    class="flex flex-col sm:flex-row gap-4 justify-center items-center"
                >
                    <a
                        href="#menu"
                        role="button"
                        class="inline-block px-8 py-4 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        Lihat Menu Kami
                    </a>
                    <a
                        href="#about"
                        role="button"
                        class="inline-block px-8 py-4 bg-transparent border-2 border-white text-white font-semibold rounded-full hover:bg-white hover:text-gray-900 transition-all duration-300 shadow-lg"
                    >
                        Tentang Kami
                    </a>
                </div>

                <!-- Scroll Indicator -->
                <div class="mt-16 animate-bounce">
                    <svg
                        class="w-6 h-6 mx-auto text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M19 14l-7 7m0 0l-7-7m7 7V3"
                        ></path>
                    </svg>
                </div>
            </div>
        </section>
        <!-- About Section -->
        <section id="about" class="py-20 px-8 bg-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-Playfair font-bold text-gray-900 mb-4"
                    >
                        Tentang Kami
                    </h2>
                    <div class="w-24 h-1 bg-amber-500 mx-auto mb-8"></div>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Kisah kami dimulai dari kecintaan terhadap kopi dan
                        hasrat untuk berbagi pengalaman kopi terbaik.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center"
                >
                    <div class="relative">
                        <div
                            class="absolute -top-4 -left-4 w-full h-full border-2 border-amber-500 z-0"
                        ></div>
                        <img
                            src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600"
                            alt="Coffee shop"
                            class="w-full h-auto object-cover relative z-10 shadow-xl"
                        />
                        <div
                            class="absolute -bottom-6 -right-6 w-32 h-32 bg-amber-500 z-0 hidden md:block"
                        ></div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="text-2xl font-semibold text-gray-800">
                            Perjalanan Kopi Kami
                        </h3>
                        <p class="text-gray-600 leading-relaxed">
                            Qio Coffee didirikan pada tahun 2020 dengan visi
                            sederhana: menyajikan kopi berkualitas tinggi dengan
                            harga terjangkau. Kami memulai sebagai kedai kopi
                            kecil di sudut jalan, dan kini telah berkembang
                            menjadi destinasi kopi favorit di kota ini.
                        </p>
                        <p class="text-gray-600 leading-relaxed">
                            Kami memilih biji kopi terbaik dari petani lokal dan
                            internasional, menyangrai dengan hati-hati untuk
                            menghasilkan profil rasa yang sempurna, dan
                            menyajikannya dengan keahlian barista kami yang
                            berpengalaman.
                        </p>

                        <div class="grid grid-cols-2 gap-4 mt-8">
                            <div
                                class="text-center p-4 border border-gray-200 rounded-lg hover:border-amber-500 transition-all"
                            >
                                <div class="text-amber-600 mb-2">
                                    <svg
                                        class="w-8 h-8 mx-auto"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"
                                        ></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold">Barista Ahli</h4>
                                <p class="text-sm text-gray-500">
                                    Tim kami terdiri dari barista berpengalaman
                                </p>
                            </div>

                            <div
                                class="text-center p-4 border border-gray-200 rounded-lg hover:border-amber-500 transition-all"
                            >
                                <div class="text-amber-600 mb-2">
                                    <svg
                                        class="w-8 h-8 mx-auto"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold">Kualitas Terbaik</h4>
                                <p class="text-sm text-gray-500">
                                    Hanya biji kopi terbaik yang kami gunakan
                                </p>
                            </div>

                            <div
                                class="text-center p-4 border border-gray-200 rounded-lg hover:border-amber-500 transition-all"
                            >
                                <div class="text-amber-600 mb-2">
                                    <svg
                                        class="w-8 h-8 mx-auto"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM12 2a1 1 0 01.967.744L14.146 7.2 17.5 9.134a1 1 0 010 1.732l-3.354 1.935-1.18 4.455a1 1 0 01-1.933 0L9.854 12.8 6.5 10.866a1 1 0 010-1.732l3.354-1.935 1.18-4.455A1 1 0 0112 2z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold">Inovasi</h4>
                                <p class="text-sm text-gray-500">
                                    Selalu berinovasi dengan menu baru
                                </p>
                            </div>

                            <div
                                class="text-center p-4 border border-gray-200 rounded-lg hover:border-amber-500 transition-all"
                            >
                                <div class="text-amber-600 mb-2">
                                    <svg
                                        class="w-8 h-8 mx-auto"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </div>
                                <h4 class="font-semibold">Suasana Nyaman</h4>
                                <p class="text-sm text-gray-500">
                                    Tempat yang nyaman untuk bersantai
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Menu Section -->
        <section id="menu" class="py-20 px-8 bg-gray-100">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-Playfair font-bold text-gray-900 mb-4"
                    >
                        Menu Kami
                    </h2>
                    <div class="w-24 h-1 bg-amber-500 mx-auto mb-8"></div>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Nikmati berbagai pilihan kopi dan makanan pendamping
                        yang kami sajikan dengan cinta.
                    </p>
                </div>

                <!-- Menu Filter -->
                <div class="flex flex-wrap justify-center gap-4 mb-12">
                    <button
                        wire:click="filterByCategory(null)"
                        class="px-6 py-2 rounded-full font-medium transition-all duration-200 shadow-sm {{ is_null($selectedCategory) ? "bg-amber-600 text-white" : "bg-white text-gray-800 hover:bg-gray-200" }}"
                    >
                        Semua
                    </button>
                    @foreach ($categories as $category)
                        <button
                            wire:click="filterByCategory('{{ $category->name }}')"
                            class="px-6 py-2 cursor-pointer rounded-full font-medium transition-all duration-200 shadow-sm {{ $selectedCategory == $category->name ? "bg-amber-600 text-white" : "bg-white text-gray-800 hover:bg-gray-200" }}"
                        >
                            {{ $category->name }}
                        </button>
                    @endforeach
                </div>

                <!-- Menu Items -->
                <div
                    wire:loading.class.delay="opacity-50 transition-opacity"
                    wire:target="filterByCategory"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8"
                >
                    @foreach ($products as $product)
                        <div
                            class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-all duration-300"
                        >
                            <img
                                src="{{ $product->image ?? asset("images/default-coffee-menu.jpg") }}"
                                alt="{{ $product->name }}"
                                class="w-full h-48 object-cover"
                                onerror="this.onerror=null;this.src='{{ asset("images/default-coffee-menu.jpg") }}';"
                            />
                            <div class="p-6">
                                <div
                                    class="flex justify-between items-center mb-4"
                                >
                                    <h3
                                        class="text-xl font-semibold text-gray-800"
                                    >
                                        {{ $product->name }}
                                    </h3>
                                    <span class="text-amber-600 font-bold">
                                        Rp
                                        {{ number_format($product->price, 0, ",", ".") }}
                                    </span>
                                </div>
                                <p class="text-gray-600 mb-4">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- View Full Menu Button -->
                <div class="text-center mt-12">
                    <button
                        class="px-8 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        Lihat Menu Lengkap
                    </button>
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        <section
            id="testimonials"
            class="py-20 px-8 bg-gradient-to-br from-gray-50 to-gray-100"
        >
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-Playfair font-bold text-gray-900 mb-4"
                    >
                        Apa Kata Mereka
                    </h2>
                    <div class="w-24 h-1 bg-amber-500 mx-auto mb-8"></div>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Testimoni dari pelanggan setia yang telah merasakan
                        pengalaman kopi terbaik di Qio Coffee.
                    </p>
                </div>

                <!-- Testimonials Carousel -->
                <div
                    x-data="{
                        currentSlide: 0,
                        testimonials: [
                            {
                                name: 'Riska Pratiwi',
                                role: 'Content Creator',
                                image: 'https://i.pravatar.cc/150?img=5',
                                rating: 5,
                                text: 'Qio Coffee adalah tempat favorit saya untuk bekerja! Kopinya enak, WiFi cepat, dan suasananya sangat nyaman. Cappuccino mereka adalah yang terbaik yang pernah saya coba di Medan.',
                                date: '2 minggu yang lalu',
                            },
                            {
                                name: 'Andi Wijaya',
                                role: 'Entrepreneur',
                                image: 'https://i.pravatar.cc/150?img=12',
                                rating: 5,
                                text: 'Sebagai penikmat kopi, saya sangat puas dengan kualitas biji kopi yang digunakan. Pour Over mereka benar-benar memunculkan karakter kopi yang kompleks. Highly recommended!',
                                date: '1 bulan yang lalu',
                            },
                            {
                                name: 'Sarah Melinda',
                                role: 'Marketing Manager',
                                image: 'https://i.pravatar.cc/150?img=9',
                                rating: 5,
                                text: 'Tempat yang sempurna untuk meeting dengan klien atau sekadar me-time. Pelayanan ramah, menu beragam, dan harga sangat reasonable. Cheesecake-nya juga juara!',
                                date: '3 minggu yang lalu',
                            },
                            {
                                name: 'Budi Santoso',
                                role: 'Software Developer',
                                image: 'https://i.pravatar.cc/150?img=14',
                                rating: 5,
                                text: 'Sudah langganan di sini hampir setahun. Iced Americano mereka selalu konsisten rasanya. Barista-nya juga friendly dan profesional. Sukses terus Qio Coffee!',
                                date: '1 minggu yang lalu',
                            },
                            {
                                name: 'Dian Kusuma',
                                role: 'Graphic Designer',
                                image: 'https://i.pravatar.cc/150?img=20',
                                rating: 5,
                                text: 'Ambiance-nya cozy banget! Instagram-able dan cocok buat foto-foto. Yang paling saya suka adalah Matcha Latte mereka yang creamy dan tidak terlalu manis. Perfect!',
                                date: '2 bulan yang lalu',
                            },
                        ],
                        autoplay: null,
                        init() {
                            this.startAutoplay()
                        },
                        startAutoplay() {
                            this.autoplay = setInterval(() => {
                                this.next()
                            }, 5000)
                        },
                        stopAutoplay() {
                            clearInterval(this.autoplay)
                        },
                        next() {
                            this.currentSlide = (this.currentSlide + 1) % this.testimonials.length
                        },
                        prev() {
                            this.currentSlide =
                                this.currentSlide === 0
                                    ? this.testimonials.length - 1
                                    : this.currentSlide - 1
                        },
                        goToSlide(index) {
                            this.currentSlide = index
                        },
                    }"
                    @mouseenter="stopAutoplay()"
                    @mouseleave="startAutoplay()"
                    class="relative"
                >
                    <!-- Main Testimonial Card -->
                    <div class="relative overflow-hidden">
                        <template
                            x-for="(testimonial, index) in testimonials"
                            :key="index"
                        >
                            <div
                                x-show="currentSlide === index"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 transform translate-x-full"
                                x-transition:enter-end="opacity-100 transform translate-x-0"
                                x-transition:leave="transition ease-in duration-500"
                                x-transition:leave-start="opacity-100 transform translate-x-0"
                                x-transition:leave-end="opacity-0 transform -translate-x-full"
                                class="bg-white rounded-2xl shadow-xl p-8 md:p-12"
                            >
                                <!-- Quote Icon -->
                                <div class="flex justify-center mb-6">
                                    <div
                                        class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center"
                                    >
                                        <svg
                                            class="w-8 h-8 text-amber-600"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"
                                            />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="flex justify-center mb-4">
                                    <template x-for="star in 5" :key="star">
                                        <svg
                                            class="w-5 h-5 text-amber-500"
                                            fill="currentColor"
                                            viewBox="0 0 20 20"
                                        >
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                            />
                                        </svg>
                                    </template>
                                </div>

                                <!-- Testimonial Text -->
                                <p
                                    class="text-gray-700 text-lg md:text-xl text-center leading-relaxed mb-8 italic"
                                    x-text="testimonial.text"
                                ></p>

                                <!-- Customer Info -->
                                <div class="flex flex-col items-center">
                                    <img
                                        :src="testimonial.image"
                                        :alt="testimonial.name"
                                        class="w-20 h-20 rounded-full object-cover mb-4 border-4 border-amber-500"
                                    />
                                    <h4
                                        class="text-xl font-semibold text-gray-900"
                                        x-text="testimonial.name"
                                    ></h4>
                                    <p
                                        class="text-amber-600 font-medium mb-1"
                                        x-text="testimonial.role"
                                    ></p>
                                    <p
                                        class="text-gray-500 text-sm"
                                        x-text="testimonial.date"
                                    ></p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Navigation Arrows -->
                    <button
                        @click="prev()"
                        class="absolute left-0 top-1/2 -translate-y-1/2 -translate-x-4 md:-translate-x-12 w-12 h-12 bg-white hover:bg-amber-600 rounded-full shadow-lg flex items-center justify-center text-gray-800 hover:text-white transition-all duration-300 group"
                    >
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 19l-7-7 7-7"
                            ></path>
                        </svg>
                    </button>

                    <button
                        @click="next()"
                        class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-4 md:translate-x-12 w-12 h-12 bg-white hover:bg-amber-600 rounded-full shadow-lg flex items-center justify-center text-gray-800 hover:text-white transition-all duration-300 group"
                    >
                        <svg
                            class="w-6 h-6"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 5l7 7-7 7"
                            ></path>
                        </svg>
                    </button>

                    <!-- Dots Navigation -->
                    <div class="flex justify-center mt-8 space-x-2">
                        <template
                            x-for="(testimonial, index) in testimonials"
                            :key="index"
                        >
                            <button
                                @click="goToSlide(index)"
                                :class="{ 'bg-amber-600 w-8': currentSlide === index, 'bg-gray-300 w-2': currentSlide !== index }"
                                class="h-2 rounded-full transition-all duration-300 hover:bg-amber-500"
                            ></button>
                        </template>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-16">
                    <div
                        class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
                    >
                        <div class="text-4xl font-bold text-amber-600 mb-2">
                            4.9
                        </div>
                        <div class="text-gray-600 font-medium">
                            Rating Google
                        </div>
                        <div class="flex justify-center mt-2">
                            <template x-for="star in 5">
                                <svg
                                    class="w-4 h-4 text-amber-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                                    />
                                </svg>
                            </template>
                        </div>
                    </div>

                    <div
                        class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
                    >
                        <div class="text-4xl font-bold text-amber-600 mb-2">
                            500+
                        </div>
                        <div class="text-gray-600 font-medium">
                            Happy Customers
                        </div>
                    </div>

                    <div
                        class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
                    >
                        <div class="text-4xl font-bold text-amber-600 mb-2">
                            2K+
                        </div>
                        <div class="text-gray-600 font-medium">Cups Served</div>
                    </div>

                    <div
                        class="text-center p-6 bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300"
                    >
                        <div class="text-4xl font-bold text-amber-600 mb-2">
                            3+
                        </div>
                        <div class="text-gray-600 font-medium">
                            Years Experience
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Gallery Section -->
        <section id="gallery" class="py-20 px-8 bg-white">
            <div class="max-w-6xl mx-auto">
                <div class="text-center mb-16">
                    <h2
                        class="text-4xl md:text-5xl font-Playfair font-bold text-gray-900 mb-4"
                    >
                        Galeri Kami
                    </h2>
                    <div class="w-24 h-1 bg-amber-500 mx-auto mb-8"></div>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Lihat suasana dan momen-momen spesial di Qio Coffee.
                    </p>
                </div>

                <!-- Gallery Grid -->
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4"
                >
                    <!-- Gallery Item 1 - Large -->
                    <div
                        class="relative overflow-hidden rounded-lg shadow-lg lg:col-span-2 lg:row-span-2 group"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800"
                            alt="Coffee Shop Interior"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
                        >
                            <h3 class="text-white text-xl font-semibold">
                                Interior Qio Coffee
                            </h3>
                            <p class="text-gray-200 mt-2">
                                Suasana nyaman untuk bersantai dan bekerja
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Item 2 -->
                    <div
                        class="relative overflow-hidden rounded-lg shadow-lg group"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600"
                            alt="Coffee Brewing"
                            class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
                        >
                            <h3 class="text-white text-lg font-semibold">
                                Proses Brewing
                            </h3>
                            <p class="text-gray-200 mt-2">Seni menyeduh kopi</p>
                        </div>
                    </div>

                    <!-- Gallery Item 3 -->
                    <div
                        class="relative overflow-hidden rounded-lg shadow-lg group"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1511081692775-05d0f180a065?w=600"
                            alt="Coffee Beans"
                            class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
                        >
                            <h3 class="text-white text-lg font-semibold">
                                Biji Kopi Pilihan
                            </h3>
                            <p class="text-gray-200 mt-2">
                                Kualitas terbaik dari petani lokal
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Item 4 -->
                    <div
                        class="relative overflow-hidden rounded-lg shadow-lg group"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1513267048331-5611cad62e41?w=600"
                            alt="Coffee Art"
                            class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
                        >
                            <h3 class="text-white text-lg font-semibold">
                                Latte Art
                            </h3>
                            <p class="text-gray-200 mt-2">
                                Kreasi seni di setiap cangkir
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Item 5 -->
                    <div
                        class="relative overflow-hidden rounded-lg shadow-lg group"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1554118811-1e0d58224f24?w=600"
                            alt="Coffee Shop Event"
                            class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
                        >
                            <h3 class="text-white text-lg font-semibold">
                                Event Spesial
                            </h3>
                            <p class="text-gray-200 mt-2">
                                Workshop dan gathering komunitas
                            </p>
                        </div>
                    </div>

                    <!-- Gallery Item 6 -->
                    <div
                        class="relative overflow-hidden rounded-lg shadow-lg group"
                    >
                        <img
                            src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=600"
                            alt="Coffee and Dessert"
                            class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
                        >
                            <h3 class="text-white text-lg font-semibold">
                                Dessert Spesial
                            </h3>
                            <p class="text-gray-200 mt-2">
                                Pendamping sempurna untuk kopi Anda
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Instagram Link -->
                <div class="text-center mt-12">
                    <a
                        href="{{ $this->shopProfile->instagram }}"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-amber-500 to-amber-700 text-white font-semibold rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 mr-2"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"
                            />
                        </svg>
                        Ikuti Kami di Instagram
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer
        class="relative bg-gradient-to-br from-stone-900 to-black text-white py-20 px-8 overflow-hidden"
    >
        <!-- Decorative Background Elements -->
        <div class="absolute inset-0 opacity-5">
            <div
                class="absolute top-10 left-10 w-32 h-32 border border-amber-500 rounded-full"
            ></div>
            <div
                class="absolute bottom-20 right-20 w-40 h-40 border border-amber-500 rounded-full"
            ></div>
            <div
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2"
            >
                <svg
                    class="w-64 h-64 text-amber-600 opacity-30"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        d="M18.5 2c1.38 0 2.5 1.12 2.5 2.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6h-3V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H8V4.5c0-.28-.22-.5-.5-.5s-.5.22-.5.5V6H4V4.5C4 3.12 5.12 2 6.5 2h12z"
                    />
                </svg>
            </div>
        </div>

        <div class="max-w-6xl mx-auto relative z-10">
            <!-- Main Footer Content -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16">
                <!-- About Column -->
                <div>
                    <h3
                        class="text-lg font-semibold text-amber-500 mb-6 font-Playfair"
                    >
                        Tentang Kami
                    </h3>
                    <ul class="space-y-3 text-gray-400">
                        <li>
                            <a
                                href="#about"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Kisah Kami
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Tim Barista
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Testimoni
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Karir
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Menu Column -->
                <div>
                    <h3
                        class="text-lg font-semibold text-amber-500 mb-6 font-Playfair"
                    >
                        Menu
                    </h3>
                    <ul class="space-y-3 text-gray-400">
                        <li>
                            <a
                                href="#menu"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Kopi Signature
                            </a>
                        </li>
                        <li>
                            <a
                                href="#menu"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Non-Kopi
                            </a>
                        </li>
                        <li>
                            <a
                                href="#menu"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Makanan
                            </a>
                        </li>
                        <li>
                            <a
                                href="#"
                                class="hover:text-amber-500 transition-colors duration-200 flex items-center group"
                            >
                                <span
                                    class="w-0 group-hover:w-2 h-0.5 bg-amber-500 mr-0 group-hover:mr-2 transition-all duration-200"
                                ></span>
                                Promo Spesial
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Contact Column -->
                <div>
                    <h3
                        class="text-lg font-semibold text-amber-500 mb-6 font-Playfair"
                    >
                        Hubungi Kami
                    </h3>
                    <ul class="space-y-4 text-gray-400">
                        <li class="flex items-start">
                            <svg
                                class="w-5 h-5 text-amber-500 mr-3 mt-0.5 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                ></path>
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                ></path>
                            </svg>
                            <span>
                                {{ $this->shopProfile->address }}
                            </span>
                        </li>
                        <li class="flex items-center">
                            <svg
                                class="w-5 h-5 text-amber-500 mr-3 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                ></path>
                            </svg>
                            <span>{{ $this->shopProfile->phone }}</span>
                        </li>
                        <li class="flex items-center">
                            <svg
                                class="w-5 h-5 text-amber-500 mr-3 flex-shrink-0"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                ></path>
                            </svg>
                            <span>{{ $this->shopProfile->email }}</span>
                        </li>
                    </ul>
                </div>

                <!-- Hours Column -->
                <div>
                    <h3
                        class="text-lg font-semibold text-amber-500 mb-6 font-Playfair"
                    >
                        Jam Operasional
                    </h3>
                    <div class="space-y-3 text-gray-400">
                        <div
                            class="flex items-center justify-between pb-3 border-b border-gray-700"
                        >
                            <span class="font-medium">
                                {{ $this->shopProfile->operating_days }}
                            </span>
                        </div>
                        <div class="flex items-center text-amber-500">
                            <svg
                                class="w-4 h-4 mr-2"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                ></path>
                            </svg>
                            <span>
                                {{ $this->shopProfile->operating_hours }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Social Media & Newsletter Section -->
            <div class="border-t border-gray-800 pt-12 pb-8">
                <div
                    class="flex flex-col md:flex-row justify-between items-center gap-8"
                >
                    <!-- Social Media -->
                    <div class="text-center md:text-left">
                        <h4 class="text-amber-500 font-semibold mb-4">
                            Ikuti Kami
                        </h4>
                        <div class="flex space-x-4">
                            <a
                                href="{{ $this->shopProfile->facebook }}"
                                class="w-10 h-10 rounded-full bg-white/5 hover:bg-amber-600 border border-gray-700 hover:border-amber-600 flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300"
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"
                                    />
                                </svg>
                            </a>
                            <a
                                href="{{ $this->shopProfile->instagram }}"
                                class="w-10 h-10 rounded-full bg-white/5 hover:bg-amber-600 border border-gray-700 hover:border-amber-600 flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300"
                            >
                                <svg
                                    class="w-5 h-5"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                    />
                                </svg>
                            </a>
                            <a
                                href="{{ $this->shopProfile->tiktok }}"
                                class="w-10 h-10 rounded-full bg-white/5 hover:bg-amber-600 border border-gray-700 hover:border-amber-600 flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300"
                            ></a>
                        </div>
                    </div>

                    <!-- Newsletter Signup -->
                    <div class="text-center md:text-right">
                        <h4 class="text-amber-500 font-semibold mb-4">
                            Newsletter
                        </h4>
                        <form class="flex flex-col sm:flex-row gap-2">
                            <input
                                type="email"
                                placeholder="Email Anda"
                                class="px-4 py-2 bg-white/5 border border-gray-700 rounded-full text-gray-300 placeholder-gray-500 focus:outline-none focus:border-amber-500 transition-colors"
                            />
                            <button
                                type="submit"
                                class="px-6 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-full transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-105"
                            >
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div
                class="border-t border-gray-800 pt-8 mt-8 text-center text-gray-500 text-sm"
            >
                <p>
                    &copy; 2025 {{ $this->shopProfile->name }}. All rights
                    reserved
                </p>
            </div>
        </div>

        <!-- Back to Top Button -->
        <div
            class="fixed bottom-8 right-8 z-40"
            x-data="{ show: false }"
            @scroll.window="show = (window.pageYOffset > 300)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-4"
        >
            <a
                href="#home"
                title="Back to Top"
                class="flex flex-col items-center group"
            >
                <div
                    class="w-12 h-12 bg-amber-600 hover:bg-amber-700 rounded-full flex items-center justify-center shadow-lg transition-all duration-300 transform group-hover:scale-110"
                >
                    <svg
                        class="w-6 h-6"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 10l7-7m0 0l7 7m-7-7v18"
                        ></path>
                    </svg>
                </div>
                <span
                    class="text-xs text-white mt-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                >
                    Back to Top
                </span>
            </a>
        </div>
    </footer>
</div>
