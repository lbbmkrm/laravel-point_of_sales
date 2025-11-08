<?php

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Gate;

new #[Title("Products")] class extends Component {
    public ProductForm $form;
    public Collection $products;
    public Collection $categories;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $isEditMode = false;
    public ?Product $productToDelete = null;

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
        $this->form->reset();
        $this->showModal = true;
    }

    public function edit(Product $product): void
    {
        Gate::authorize("update", $product);
        $this->isEditMode = true;
        $this->form->setProduct($product);
        $this->showModal = true;
    }

    public function save(ProductService $productService): void
    {
        try {
            $validated = $this->form->validate();

            if ($this->isEditMode) {
                $productService->updateProduct(
                    $this->form->product,
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
                $this->productToDelete = null;
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
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->showDeleteModal = false;
        $this->form->reset();
    }
};
?>

<div x-data class="p-6 space-y-6">
    {{-- Flash messages --}}
    @if (session("success"))
        <div
            x-transition.opacity
            class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded shadow-sm"
        >
            {{ session("success") }}
        </div>
    @elseif (session("error"))
        <div
            x-transition.opacity
            class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded shadow-sm"
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
                class="bg-amber-600 hover:bg-amber-700 text-white font-medium px-4 py-2 rounded-lg transition-all duration-200 shadow-sm hover:shadow-md cursor-pointer"
            >
                + Tambah Produk
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
                    <tr>
                        <td class="px-4 py-3">{{ $product->name }}</td>
                        <td class="px-4 py-3">
                            Rp.&nbsp;{{ number_format($product->price, 0, ",", ".") }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $product->category->name ?? "-" }}
                        </td>

                        @canany(["update", "delete"], $product)
                            <td
                                class="px-4 py-3 flex justify-between items-center space-x-2"
                            >
                                @can("update", $product)
                                    <button
                                        wire:click="edit({{ $product->id }})"
                                        class="inline-flex items-center justify-center p-2 rounded-lg bg-blue-50 hover:bg-blue-100 transition-all duration-200 cursor-pointer"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 md:w-5 md:h-5 text-sky-600"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                                            />
                                        </svg>
                                    </button>
                                @endcan

                                @can("delete", $product)
                                    <button
                                        wire:click="delete({{ $product->id }})"
                                        class="inline-flex items-center justify-center p-2 rounded-lg bg-red-50 hover:bg-red-100 transition-all duration-200 cursor-pointer"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 md:w-5 md:h-5 text-red-600"
                                            viewBox="0 0 20 20"
                                            fill="currentColor"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                clip-rule="evenodd"
                                            />
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
                            class="text-center text-gray-500 py-8"
                        >
                            Belum ada produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal Tambah/Edit Produk --}}
    <div
        x-show="$wire.showModal"
        x-transition.opacity.scale.95
        x-cloak
        class="fixed h-full inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50"
    >
        <div
            x-transition
            class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all duration-300"
        >
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-gray-800">
                    {{ $isEditMode ? "Edit Produk" : "Tambah Produk" }}
                </h2>
                <button
                    wire:click="closeModal"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-150 cursor-pointer"
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
                        />
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Produk
                    </label>
                    <input
                        wire:model="form.name"
                        type="text"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none"
                    />
                    @error("form.name")
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Harga
                    </label>
                    <input
                        wire:model="form.price"
                        type="number"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none"
                    />
                    @error("form.price")
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi
                    </label>
                    <textarea
                        wire:model="form.description"
                        rows="3"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 outline-none"
                    ></textarea>
                    @error("form.description")
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end space-x-2 pt-2">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-all duration-150 cursor-pointer"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-lg font-medium transition-all duration-150 cursor-pointer"
                    >
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div
        x-show="$wire.showDeleteModal"
        x-transition.opacity.scale.90
        x-cloak
        class="fixed inset-0 bg-black/40 backdrop-blur-sm flex items-center justify-center z-50"
    >
        <div
            x-transition
            class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform transition-all duration-300"
        >
            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                Hapus Produk
            </h2>
            <p class="text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus produk ini?
            </p>
            <div class="flex justify-end space-x-2">
                <button
                    wire:click="closeModal"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition-all duration-150 cursor-pointer"
                >
                    Batal
                </button>
                <button
                    wire:click="confirmDelete"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-all duration-150 cursor-pointer"
                >
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
