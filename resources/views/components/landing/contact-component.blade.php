@props([
    "shopProfile",
])

<section id="contact" class="py-20 px-8 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2
                class="text-4xl md:text-5xl font-Playfair font-bold text-gray-900 mb-4"
            >
                Hubungi & Lokasi
            </h2>
            <div class="w-24 h-1 bg-amber-500 mx-auto mb-8"></div>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Kunjungi kedai kami atau hubungi kami untuk informasi lebih
                lanjut dan pemesanan tempat.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-stretch">
            <!-- Contact Info -->
            <div
                class="bg-white rounded-3xl shadow-xl p-8 md:p-12 flex flex-col justify-between overflow-hidden relative"
            >
                <!-- Decorative element -->
                <div
                    class="absolute -top-10 -right-10 w-40 h-40 bg-amber-500/5 rounded-full"
                ></div>

                <div class="relative z-10">
                    <h3 class="text-2xl font-bold text-gray-800 mb-8">
                        Informasi Kontak
                    </h3>

                    <div class="space-y-8">
                        <!-- Address -->
                        <div class="flex items-start group">
                            <div
                                class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mr-5 flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300"
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
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                                    ></path>
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                                    ></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">
                                    Alamat
                                </h4>
                                <p class="text-gray-600 leading-relaxed">
                                    {{ $shopProfile->address }}
                                </p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="flex items-start group">
                            <div
                                class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mr-5 flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300"
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
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                    ></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">
                                    Telepon
                                </h4>
                                <p class="text-gray-600">
                                    {{ $shopProfile->phone }}
                                </p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="flex items-start group">
                            <div
                                class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mr-5 flex-shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300"
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
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                                    ></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">
                                    Email
                                </h4>
                                <p class="text-gray-600">
                                    {{ $shopProfile->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 relative z-10">
                    <a
                        href="https://wa.me/{{ preg_replace("/[^0-9]/", "", $shopProfile->phone) }}"
                        target="_blank"
                        class="inline-flex items-center justify-center w-full px-8 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-2xl transition-all duration-300 shadow-lg shadow-green-500/30 transform hover:-translate-y-1"
                    >
                        <svg
                            class="w-6 h-6 mr-3"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"
                            ></path>
                        </svg>
                        Chat via WhatsApp
                    </a>
                </div>
            </div>

            <!-- Map -->
            <div
                class="rounded-3xl shadow-xl overflow-hidden min-h-[400px] border-8 border-white"
            >
                <iframe
                    width="100%"
                    height="100%"
                    style="border: 0; min-height: 400px"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    src="{{ $shopProfile->google_maps_url ?? "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15931.32431665671!2d98.6666!3d3.59!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x303131b7f0f0f0f0%3A0x0!2sMedan%2C%20Kota%20Medan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" }}"
                ></iframe>
            </div>
        </div>
    </div>
</section>
