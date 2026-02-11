<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};
use App\Models\Gallery;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
new #[Layout("layouts.app")] #[Title("Gallery")] class extends Component {
    use WithFileUploads;

    public $galleries;
    public $showModal = false;
    public $isEditMode = false;
    public $editingGallery = null;

    // form fields
    public $image;
    public $existingImage;
    public $title;
    public $description;

    public function mount()
    {
        $this->loadGalleries();
    }

    public function loadGalleries()
    {
        $this->galleries = Gallery::orderBy("created_at", "desc")->get();
    }

    public function save()
    {
        $rules = [
            "title" => "required|string|max:100",
            "description" => "required|string|max:255",
        ];

        if (! $this->isEditMode) {
            $rules["image"] = "required|image|max:5120";
        }

        $validated = $this->validate($rules);

        if ($this->image) {
            $validated["image"] = $this->image->store("galleries", "public");
        }

        if ($this->isEditMode) {
            if ($this->image && $this->existingImage) {
                Storage::disk("public")->delete($this->existingImage);
            }
            $this->editingGallery->update($validated);
        } else {
            Gallery::create($validated);
        }

        $this->resetForm();
        $this->loadGalleries();
        $this->closeModal();
        session()->flash("success", "Gallery berhasil disimpan!");
    }

    public function edit(Gallery $gallery)
    {
        $this->editingGallery = $gallery;
        $this->isEditMode = true;
        $this->title = $gallery->title;
        $this->description = $gallery->description;
        $this->existingImage = $gallery->image;
        $this->showModal = true;
    }

    public function delete(Gallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk("public")->delete($gallery->image);
        }
        $gallery->delete();
        $this->loadGalleries();
        session()->flash("success", "Item galeri berhasil dihapus!");
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            "image",
            "existingImage",
            "title",
            "description",
            "isEditMode",
        ]);
    }
}; ?>

<div class="max-w-7xl mx-auto py-8 px-4">
    <!-- Header -->
    <div
        class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8"
    >
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Manajemen Galeri</h1>
            <p class="text-gray-600 mt-1">
                Kelola foto suasana dan menu untuk ditampilkan di landing page
            </p>
        </div>
        <button
            wire:click="openModal"
            class="inline-flex items-center justify-center px-4 py-2.5 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition shadow-md shadow-amber-200"
        >
            <i class="ri-add-line mr-2"></i>
            Tambah Foto
        </button>
    </div>

    <!-- Alert Success -->
    @if (session("success"))
        <div
            class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center"
            x-data="{ show: true }"
            x-show="show"
            x-init="setTimeout(() => (show = false), 3000)"
        >
            <i class="ri-checkbox-circle-line mr-2 text-xl"></i>
            {{ session("success") }}
        </div>
    @endif

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($galleries as $gallery)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-md transition-shadow duration-300"
            >
                <div class="relative aspect-video overflow-hidden">
                    <img
                        src="{{ $gallery->image_url }}"
                        alt="{{ $gallery->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    />
                    <div
                        class="absolute top-2 right-2 flex gap-2 md:opacity-0 md:group-hover:opacity-100 transition-opacity duration-300"
                    >
                        <button
                            wire:click="edit({{ $gallery->id }})"
                            class="w-8 h-8 p-2 bg-white/50 backdrop-blur-sm text-indigo-600 rounded-full flex items-center justify-center hover:bg-indigo-600 hover:text-white transition-colors duration-200 shadow-md"
                            title="Edit foto"
                        >
                            <i class="ri-pencil-line text-lg"></i>
                        </button>
                        <button
                            wire:click="delete({{ $gallery->id }})"
                            wire:confirm="Apakah Anda yakin ingin menghapus foto ini?"
                            class="w-8 h-8 p-2 bg-white/50 backdrop-blur-sm text-red-600 rounded-full flex items-center justify-center hover:bg-red-600 hover:text-white transition-colors duration-200 shadow-md"
                            title="Hapus foto"
                        >
                            <i class="ri-delete-bin-line text-lg"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-900 line-clamp-1 mb-1">
                        {{ $gallery->title }}
                    </h3>
                    <p class="text-sm text-gray-500 line-clamp-2">
                        {{ $gallery->description }}
                    </p>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-12 flex flex-col items-center justify-center bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200"
            >
                <i class="ri-image-2-line text-6xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 mb-1 font-medium">
                    Belum ada foto galeri.
                </p>
                <p class="text-gray-400 text-sm mb-4">
                    Mulai dengan mengunggah foto pertama Anda
                </p>
                <button
                    wire:click="openModal"
                    class="px-4 py-2 bg-amber-600 text-white font-semibold rounded-lg hover:bg-amber-700 transition-colors"
                >
                    <i class="ri-add-line mr-1"></i>
                    Unggah Foto Pertama
                </button>
            </div>
        @endforelse
    </div>

    <!-- Modal Form - Pure Livewire -->
    @if ($showModal)
        <div
            class="fixed inset-0 z-50 overflow-y-auto"
            style="animation: fadeIn 0.3s ease-out"
        >
            <div
                class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
            >
                <!-- Backdrop -->
                <div
                    wire:click="closeModal"
                    class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity"
                    style="animation: fadeIn 0.3s ease-out"
                ></div>

                <!-- Center Modal Trick -->
                <span
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                    aria-hidden="true"
                >
                    &#8203;
                </span>

                <!-- Modal Content -->
                <div
                    class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transform bg-white shadow-xl rounded-2xl sm:align-middle relative"
                    style="animation: slideUp 0.3s ease-out"
                    @click.stop
                >
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gray-900">
                            {{ $isEditMode ? "Edit Foto Galeri" : "Tambah Foto Galeri" }}
                        </h3>
                        <button
                            wire:click="closeModal"
                            type="button"
                            class="text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <i class="ri-close-line text-2xl"></i>
                        </button>
                    </div>

                    <!-- Form -->
                    <form wire:submit.prevent="save" class="space-y-4">
                        <!-- Image Upload -->
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Foto Galeri
                                @if (! $isEditMode)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            <!-- Image Preview -->

                            @if ($image)
                                <div
                                    class="mb-3 relative rounded-lg overflow-hidden aspect-video bg-gray-100"
                                >
                                    <img
                                        src="{{ $image->temporaryUrl() }}"
                                        class="w-full h-full object-cover"
                                        alt="Preview"
                                    />
                                    <button
                                        type="button"
                                        wire:click="$set('image', null)"
                                        class="w-10 h-10 absolute top-2 right-2 p-1.5 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors"
                                        title="Hapus preview"
                                    >
                                        <i class="ri-close-line text-lg"></i>
                                    </button>
                                </div>
                            @elseif ($existingImage)
                                <div
                                    class="mb-3 relative rounded-lg overflow-hidden aspect-video bg-gray-100"
                                >
                                    <img
                                        src="{{ asset("storage/" . $existingImage) }}"
                                        class="w-full h-full object-cover"
                                        alt="Existing image"
                                    />
                                    <div
                                        class="absolute top-2 left-2 px-2 py-1 bg-blue-500 text-white text-xs rounded-md"
                                    >
                                        Foto saat ini
                                    </div>
                                </div>
                            @endif

                            <!-- Upload Area -->
                            <label
                                for="gallery-image"
                                class="flex items-center justify-center w-full px-4 py-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-amber-500 transition-colors cursor-pointer group"
                            >
                                <div class="text-center">
                                    <i
                                        class="ri-upload-cloud-2-line text-3xl text-gray-400 group-hover:text-amber-500 mb-2 transition-colors"
                                    ></i>
                                    <p
                                        class="text-sm text-gray-600 font-medium"
                                    >
                                        Klik untuk unggah atau seret foto
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        PNG, JPG maksimal 5MB
                                    </p>
                                </div>
                            </label>
                            <input
                                type="file"
                                id="gallery-image"
                                wire:model="image"
                                class="hidden"
                                accept="image/*"
                            />

                            @error("image")
                                <p
                                    class="text-red-500 text-xs mt-1 flex items-center"
                                >
                                    <i class="ri-error-warning-line mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror

                            <div
                                wire:loading
                                wire:target="image"
                                class="mt-2 text-sm text-amber-600 flex items-center"
                            >
                                <i
                                    class="ri-loader-4-line animate-spin mr-2"
                                ></i>
                                Mengunggah foto...
                            </div>
                        </div>

                        <!-- Title -->
                        <div>
                            <label
                                for="title"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Judul Foto
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                id="title"
                                wire:model="title"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition"
                                placeholder="Contoh: Brewing Method"
                                maxlength="100"
                            />
                            @error("title")
                                <p
                                    class="text-red-500 text-xs mt-1 flex items-center"
                                >
                                    <i class="ri-error-warning-line mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div>
                            <label
                                for="description"
                                class="block text-sm font-medium text-gray-700 mb-1"
                            >
                                Deskripsi Singkat
                                <span class="text-red-500">*</span>
                            </label>
                            <textarea
                                id="description"
                                wire:model="description"
                                rows="3"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition resize-none"
                                placeholder="Berikan sedikit cerita tentang foto ini..."
                                maxlength="255"
                            ></textarea>
                            @error("description")
                                <p
                                    class="text-red-500 text-xs mt-1 flex items-center"
                                >
                                    <i class="ri-error-warning-line mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 pt-6">
                            <button
                                type="button"
                                wire:click="closeModal"
                                class="flex-1 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition-colors"
                            >
                                Batal
                            </button>
                            <button
                                type="submit"
                                wire:loading.attr="disabled"
                                wire:target="save"
                                class="flex-1 py-2.5 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition-colors shadow-md shadow-amber-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span wire:loading.remove wire:target="save">
                                    {{ $isEditMode ? "Simpan Perubahan" : "Tambah Foto" }}
                                </span>
                                <span
                                    wire:loading
                                    wire:target="save"
                                    class="flex items-center justify-center"
                                >
                                    <i
                                        class="ri-loader-4-line animate-spin mr-2"
                                    ></i>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Add CSS Animations -->
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(1rem) scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }
        </style>
    @endif
</div>

<!-- Add Escape Key Handler -->
<script>
    document.addEventListener('livewire:initialized', () => {
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                @this.call('closeModal');
            }
        });
    });
</script>
