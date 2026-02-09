@props([
    "shopProfile",
])

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
                            {{ $shopProfile->address }}
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
                        <span>{{ $shopProfile->phone }}</span>
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
                        <span>{{ $shopProfile->email }}</span>
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
                            {{ $shopProfile->operating_days }}
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
                            {{ $shopProfile->operating_hours }}
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
                            href="{{ $shopProfile->facebook }}"
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
                            href="{{ $shopProfile->instagram }}"
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
                            href="{{ $shopProfile->tiktok }}"
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
            <p>&copy; 2025 {{ $shopProfile->name }}. All rights reserved</p>
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
