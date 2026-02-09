@props([
    "shopProfile",
])

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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
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
            <div class="relative overflow-hidden rounded-lg shadow-lg group">
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
            <div class="relative overflow-hidden rounded-lg shadow-lg group">
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
            <div class="relative overflow-hidden rounded-lg shadow-lg group">
                <img
                    src="https://images.unsplash.com/photo-1513267048331-5611cad62e41?w=600"
                    alt="Coffee Art"
                    class="w-full h-64 object-cover transition-transform duration-500 group-hover:scale-110"
                />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-end p-6"
                >
                    <h3 class="text-white text-lg font-semibold">Latte Art</h3>
                    <p class="text-gray-200 mt-2">
                        Kreasi seni di setiap cangkir
                    </p>
                </div>
            </div>

            <!-- Gallery Item 5 -->
            <div class="relative overflow-hidden rounded-lg shadow-lg group">
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
            <div class="relative overflow-hidden rounded-lg shadow-lg group">
                <img
                    src="https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=600"
                    alt="Coffee and Dessert"
                    loading="lazy"
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
                href="{{ $shopProfile->instagram }}"
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
