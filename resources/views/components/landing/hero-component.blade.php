@props([
    "shopProfile",
])

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
            {{ $shopProfile->landing_description }}
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
