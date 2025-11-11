<?php

use App\Models\Product;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

new #[Title("Products")] class extends Component {
    public Collection $products;
    public Collection $categories;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $isEditMode = false;
    public ?Product $productToDelete = null;
    public ?Product $editingProduct = null;

    // Form fields
    public string $name = "";
    public ?int $price = null;
    public string $description = "";
    public ?int $category_id = null;

    protected function rules(): array
    {
        return [
            "name" => ["required", "string", "max:255"],
            "price" => ["required", "integer", "min:0"],
            "description" => ["nullable", "string"],
            "category_id" => [
                "required",
                "integer",
                Rule::exists("categories", "id"),
            ],
        ];
    }

    public function mount(
        ProductService $productService,
        CategoryService $categoryService,
    ): void {
        Gate::authorize("viewAny", Product::class);
        $this->products = $productService->getAllProducts();
        $this->categories = $categoryService->getAllCategories();
    }

    public function openModal(): void
    {
        Gate::authorize("create", Product::class);
        $this->isEditMode = false;
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(Product $product): void
    {
        Gate::authorize("update", $product);
        $this->isEditMode = true;
        $this->editingProduct = $product;

        $this->name = $product->name;
        $this->price = $product->price;
        $this->description = $product->description ?? "";
        $this->category_id = $product->category_id;

        $this->showModal = true;
    }

    public function save(ProductService $productService): void
    {
        try {
            $validated = $this->validate();

            if ($this->isEditMode) {
                $productService->updateProduct(
                    $this->editingProduct,
                    $validated,
                );
                session()->flash("success", "Produk berhasil diperbarui.");
            } else {
                $productService->createNewProduct($validated);
                session()->flash(
                    "success",
                    "Produk baru berhasil ditambahkan.",
                );
            }

            $this->closeModal();
            $this->products = $productService->getAllProducts();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            session()->flash(
                "error",
                "Anda tidak memiliki izin untuk melakukan tindakan ini.",
            );
        } catch (\Exception $e) {
            session()->flash(
                "error",
                "Terjadi kesalahan saat menyimpan produk.",
            );
        }
    }

    public function delete(Product $product): void
    {
        Gate::authorize("delete", $product);
        $this->productToDelete = $product;
        $this->showDeleteModal = true;
    }

    public function confirmDelete(ProductService $productService): void
    {
        try {
            if ($this->productToDelete) {
                $productService->deleteProduct($this->productToDelete);
                session()->flash("success", "Produk berhasil dihapus.");
                $this->products = $productService->getAllProducts();
            }
        } catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            session()->flash(
                "error",
                "Anda tidak memiliki izin untuk menghapus produk.",
            );
        } catch (\Exception $e) {
            session()->flash(
                "error",
                "Terjadi kesalahan saat menghapus produk.",
            );
        } finally {
            $this->showDeleteModal = false;
            $this->productToDelete = null;
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            "name",
            "price",
            "description",
            "category_id",
            "editingProduct",
            "isEditMode",
        ]);
    }
};
?>

<div x-data class="p-6 space-y-6 min-h-screen">
    {{-- Flash messages --}}
    @if (session("success"))
        <div
            x-transition.opacity
            class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg shadow-sm"
        >
            {{ session("success") }}
        </div>
    @elseif (session("error"))
        <div
            x-transition.opacity
            class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg shadow-sm"
        >
            {{ session("error") }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Produk</h1>
        @can("create", App\Models\Product::class)
            <button
                wire:click="openModal"
                class="bg-amber-600 hover:bg-amber-700 text-white font-medium px-4 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md flex items-center gap-2"
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
                        d="M12 4v16m8-8H4"
                    ></path>
                </svg>
                Tambah Produk
            </button>
        @endcan
    </div>

    {{-- Product table --}}
    <div
        class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-gray-100"
    >
        <table class="min-w-full text-sm text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-medium">Nama Produk</th>
                    <th class="px-4 py-3 text-left font-medium">Harga</th>
                    <th class="px-4 py-3 text-left font-medium">Kategori</th>
                    @can("hasProductActions", App\Models\Product::class)
                        <th class="px-4 py-3 text-center font-medium">Aksi</th>
                    @endcan
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium">
                            {{ $product->name }}
                        </td>
                        <td class="px-4 py-3">
                            Rp
                            {{ number_format($product->price, 0, ",", ".") }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $product->category->name ?? "-" }}
                        </td>

                        @canany(["update", "delete"], $product)
                            <td
                                class="px-4 py-3 flex justify-center items-center space-x-2"
                            >
                                @can("update", $product)
                                    <button
                                        wire:click="edit({{ $product->id }})"
                                        class="p-2 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition"
                                        title="Edit"
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
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                                            ></path>
                                        </svg>
                                    </button>
                                @endcan

                                @can("delete", $product)
                                    <button
                                        wire:click="delete({{ $product->id }})"
                                        class="p-2 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 transition"
                                        title="Hapus"
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
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                            ></path>
                                        </svg>
                                    </button>
                                @endcan
                            </td>
                        @endcanany
                    </tr>
                @empty
                    <tr>
                        <td
                            colspan="@can('hasProductActions', App\Models\Product::class) 4 @else 3 @endcan"
                            class="text-center text-gray-500 py-12"
                        >
                            Belum ada produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah/Edit Produk (Modern 2-Kolom) --}}
    <div
        x-data
        x-show="$wire.showModal"
        x-cloak
        @keydown.escape.window="$wire.closeModal()"
        class="fixed h-full inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            class="w-full h-full max-w-3xl bg-white rounded-2xl shadow-2xl p-8"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.stop
        >
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-2xl font-bold text-gray-900">
                    {{ $isEditMode ? "Edit Produk" : "Tambah Produk Baru" }}
                </h3>
                <button
                    wire:click="closeModal"
                    class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100 transition"
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
                            d="M6 18L18 6M6 6l12 12"
                        ></path>
                    </svg>
                </button>
            </div>

            <form
                wire:submit.prevent="save"
                class="grid grid-cols-1 md:grid-cols-2 gap-6"
            >
                <!-- Nama Produk -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Produk
                    </label>
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500"
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
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"
                                ></path>
                            </svg>
                        </span>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition"
                            placeholder="Contoh: Kopi Hitam"
                            required
                        />
                    </div>
                    @error("name")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Harga (Rp)
                    </label>
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500"
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
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"
                                ></path>
                            </svg>
                        </span>
                        <input
                            type="number"
                            wire:model="price"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition"
                            placeholder="15000"
                            min="0"
                            required
                        />
                    </div>
                    @error("price")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori
                    </label>
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500"
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
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                                ></path>
                            </svg>
                        </span>
                        <select
                            wire:model="category_id"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition appearance-none"
                            required
                        >
                            <option value="" disabled>Pilih kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <span
                            class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-500"
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
                                    d="M19 9l-7 7-7-7"
                                ></path>
                            </svg>
                        </span>
                    </div>
                    @error("category_id")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi (Full Width) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi (Opsional)
                    </label>
                    <div class="relative">
                        <span class="absolute top-3 left-3 text-gray-500">
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
                                    d="M4 6h16M4 12h16M4 18h7"
                                ></path>
                            </svg>
                        </span>
                        <textarea
                            wire:model="description"
                            rows="4"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition resize-none"
                            placeholder="Jelaskan produk Anda..."
                        ></textarea>
                    </div>
                    @error("description")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-4 pt-4">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="flex-1 py-3 px-4 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="flex-1 py-3 px-4 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition focus:outline-none focus:ring-2 focus:ring-amber-500 flex items-center justify-center gap-2"
                    >
                        <span wire:loading.remove wire:target="save">
                            {{ $isEditMode ? "Simpan Perubahan" : "Tambah Produk" }}
                        </span>
                        <span
                            wire:loading
                            wire:target="save"
                            class="flex items-center"
                        >
                            <svg
                                class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4"
                                ></circle>
                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                ></path>
                            </svg>
                            Menyimpan...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div
        x-data
        x-show="$wire.showDeleteModal"
        x-cloak
        @keydown.escape.window="$wire.closeModal()"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            class="w-full max-w-sm bg-white rounded-2xl shadow-2xl p-6 text-center"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.stop
        >
            <div
                class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4"
            >
                <svg
                    class="w-8 h-8 text-red-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                    ></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Hapus Produk?</h3>
            <p class="text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus
                <span class="font-semibold">
                    "{{ $productToDelete?->name }}"
                </span>
                ? Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex gap-3">
                <button
                    wire:click="closeModal"
                    class="flex-1 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition"
                >
                    Batal
                </button>
                <button
                    wire:click="confirmDelete"
                    wire:loading.attr="disabled"
                    wire:target="confirmDelete"
                    class="flex-1 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition flex items-center justify-center gap-2"
                >
                    <span wire:loading.remove wire:target="confirmDelete">
                        Hapus
                    </span>
                    <span
                        wire:loading
                        wire:target="confirmDelete"
                        class="flex items-center"
                    >
                        <svg
                            class="animate-spin h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                        >
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"
                            ></circle>
                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                            ></path>
                        </svg>
                        Menghapus...
                    </span>
                </button>
            </div>
        </div>
    </div>
</div>
