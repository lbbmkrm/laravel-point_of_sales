@props([
    "products",
    "categories",
    "selectedCategory" => null,
])

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
                Nikmati berbagai pilihan kopi dan makanan pendamping yang kami
                sajikan dengan cinta.
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
                        loading="lazy"
                        class="w-full h-48 object-cover"
                        onerror="this.onerror=null;this.src='{{ asset("images/default-coffee-menu.jpg") }}';"
                    />
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">
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
