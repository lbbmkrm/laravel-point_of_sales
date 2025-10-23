<?php

use App\Livewire\Forms\ProductForm;
use App\Models\Product;
use App\Services\ProductService;
use Livewire\Volt\Component;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Title;

new
#[Title('Products')]
class extends Component
{
    public ProductForm $form;

    public Collection $products;

    public bool $showModal = false;
    public bool $isEditMode = false;
    public ?Product $productToDelete = null;

    public function mount(ProductService $productService): void
    {
        $this->getProducts($productService);
    }

    public function getProducts(ProductService $productService): void
    {
        $this->products = $productService->getAllProducts();
    }

    public function save(ProductService $productService): void
    {
        $validatedData = $this->form->validate();

        if ($this->isEditMode) {
            $productService->updateProduct($this->form->product, $validatedData);
        } else {
            $productService->createNewProduct($validatedData);
        }

        $this->closeModal();
        $this->getProducts($productService);
    }

    public function openModal(): void
    {
        $this->isEditMode = false;
        $this->form->reset();
        $this->showModal = true;
    }

    public function edit(Product $product): void
    {
        $this->isEditMode = true;
        $this->form->setProduct($product);
        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->form->reset();
    }

    public function delete(Product $product): void
    {
        $this->productToDelete = $product;
    }

    public function cancelDelete(): void
    {
        $this->productToDelete = null;
    }

    public function confirmDelete(ProductService $productService): void
    {
        if ($this->productToDelete) {
            $productService->deleteProduct($this->productToDelete);
            $this->productToDelete = null;
            $this->getProducts($productService);
        }
    }
};

?>

<section id="product" class="p-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">
        <!-- Header Section -->
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h4 class="text-2xl font-bold text-gray-800 mb-1">Manajemen Produk</h4>
                <p class="text-sm text-gray-500">Kelola katalog menu kopi Anda</p>
            </div>
            <button wire:click="openModal" class="cursor-pointer px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-150 flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Produk
            </button>
        </div>

        <!-- Table Card -->
        <div wire:loading.class.delay="opacity-50 transition-opacity" wire:target="save,confirmDelete" class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                        @forelse ($products as $product)
                            <tr wire:key="{{ $product->id }}" class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if ($product->image)
                                            <img class="w-12 h-12 rounded-lg object-cover ring-2 ring-gray-200" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"/>
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-gray-200 flex items-center justify-center ring-2 ring-gray-200">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="ml-4">
                                            <p class="text-sm font-semibold text-gray-800">{{ $product->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600 max-w-xs">{{ Str::limit($product->description, 80) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-bold text-gray-800">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button wire:click="edit({{ $product->id }})" class="cursor-pointer p-2 text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-150 ring-1 ring-blue-200" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </button>
                                        <button wire:click="delete({{ $product->id }})" class="cursor-pointer p-2 text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-150 ring-1 ring-red-200" title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-gray-500">
                                    Belum ada produk. Silakan tambahkan produk baru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Add/Edit Modal --}}
    @if ($showModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                <form wire:submit.prevent="save">
                    <h2 class="text-xl font-semibold mb-5">{{ $isEditMode ? 'Edit Produk' : 'Tambah Produk Baru' }}</h2>

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                        <input type="text" wire:model="form.name" id="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('form.name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea wire:model="form.description" id="description" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        @error('form.description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                        <input type="number" step="500" wire:model="form.price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        @error('form.price') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end space-x-4 mt-6">
                        <button type="button" wire:click="closeModal" class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Batal</button>
                        <button type="submit" wire:loading.attr="disabled" class="cursor-pointer bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                            <svg wire:loading wire:target="save" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="save">Simpan</span>
                            <span wire:loading wire:target="save">Menyimpan...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($productToDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                <h2 class="text-xl font-semibold mb-4">Konfirmasi Hapus</h2>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus produk "<strong>{{ $productToDelete->name }}</strong>"? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex justify-end space-x-4">
                    <button wire:click="cancelDelete" class="cursor-pointer bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded-lg">Batal</button>
                    <button wire:click="confirmDelete" wire:loading.attr="disabled" class="cursor-pointer bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg flex items-center">
                        <svg wire:loading wire:target="confirmDelete" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span wire:loading.remove wire:target="confirmDelete">Ya, Hapus</span>
                        <span wire:loading wire:target="confirmDelete">Menghapus...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</section>
