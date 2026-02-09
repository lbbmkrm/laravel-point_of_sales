@props([
    "shopProfile",
])

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
                Kisah kami dimulai dari kecintaan terhadap kopi dan hasrat untuk
                berbagi pengalaman kopi terbaik.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="relative">
                <div
                    class="absolute -top-4 -left-4 w-full h-full border-2 border-amber-500 z-0"
                ></div>
                <img
                    src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=600"
                    alt="Coffee shop"
                    loading="lazy"
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
                    Qio Coffee didirikan pada tahun 2020 dengan visi sederhana:
                    menyajikan kopi berkualitas tinggi dengan harga terjangkau.
                    Kami memulai sebagai kedai kopi kecil di sudut jalan, dan
                    kini telah berkembang menjadi destinasi kopi favorit di kota
                    ini.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Kami memilih biji kopi terbaik dari petani lokal dan
                    internasional, menyangrai dengan hati-hati untuk
                    menghasilkan profil rasa yang sempurna, dan menyajikannya
                    dengan keahlian barista kami yang berpengalaman.
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
