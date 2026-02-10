<?php

use App\Models\Testimonial;
use App\Services\TestimonialService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new #[Layout("layouts.app")] #[Title("Testimonials")] class extends Component {
    public Collection $testimonials;

    public bool $showModal = false;
    public bool $showDeleteModal = false;
    public bool $isEditMode = false;
    public ?Testimonial $testimonialToDelete = null;
    public ?Testimonial $editingTestimonial = null;

    // Form fields
    public string $client_name = "";
    public string $client_role = "";
    public string $client_image = "";
    public string $testimonial_text = "";
    public int $rating = 5;
    public int $sort_order = 0;
    public bool $is_active = true;

    protected function rules(): array
    {
        return [
            "client_name" => ["required", "string", "max:255"],
            "client_role" => ["nullable", "string", "max:255"],
            "client_image" => ["nullable", "string", "max:255"], // URL for now
            "testimonial_text" => ["required", "string"],
            "rating" => ["required", "integer", "min:1", "max:5"],
            "sort_order" => ["required", "integer"],
            "is_active" => ["required", "boolean"],
        ];
    }

    public function mount(TestimonialService $testimonialService): void
    {
        $this->testimonials = $testimonialService->getAllTestimonials();
    }

    public function openModal(): void
    {
        $this->isEditMode = false;
        $this->resetForm();
        $this->showModal = true;
    }

    public function edit(Testimonial $testimonial): void
    {
        $this->isEditMode = true;
        $this->editingTestimonial = $testimonial;

        $this->client_name = $testimonial->client_name;
        $this->client_role = $testimonial->client_role ?? "";
        $this->client_image = $testimonial->client_image ?? "";
        $this->testimonial_text = $testimonial->testimonial_text;
        $this->rating = $testimonial->rating;
        $this->sort_order = $testimonial->sort_order;
        $this->is_active = (bool) $testimonial->is_active;

        $this->showModal = true;
    }

    public function save(TestimonialService $testimonialService): void
    {
        try {
            $validated = $this->validate();

            if ($this->isEditMode) {
                $testimonialService->updateTestimonial(
                    $this->editingTestimonial->id,
                    $validated,
                );
                session()->flash("message", "Testimoni berhasil diperbarui.");
            } else {
                $testimonialService->createTestimonial($validated);
                session()->flash(
                    "message",
                    "Testimoni baru berhasil ditambahkan.",
                );
            }

            $this->closeModal();
            $this->testimonials = $testimonialService->getAllTestimonials();
        } catch (\Exception $e) {
            session()->flash(
                "message",
                "Terjadi kesalahan saat menyimpan testimoni.",
            );
        }
    }

    public function delete(Testimonial $testimonial): void
    {
        $this->testimonialToDelete = $testimonial;
        $this->showDeleteModal = true;
    }

    public function confirmDelete(TestimonialService $testimonialService): void
    {
        try {
            if ($this->testimonialToDelete) {
                $testimonialService->deleteTestimonial(
                    $this->testimonialToDelete->id,
                );
                session()->flash("message", "Testimoni berhasil dihapus.");
                $this->testimonials = $testimonialService->getAllTestimonials();
            }
        } catch (\Exception $e) {
            session()->flash("message", "Gagal menghapus testimoni.");
        } finally {
            $this->showDeleteModal = false;
            $this->testimonialToDelete = null;
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
            "client_name",
            "client_role",
            "client_image",
            "testimonial_text",
            "rating",
            "sort_order",
            "is_active",
            "editingTestimonial",
            "isEditMode",
        ]);
    }
};
?>

<div class="container mx-auto p-4">
    <div
        class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6"
    >
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Manajemen Testimoni
            </h1>
            <p class="text-gray-600">
                Kelola apa yang dikatakan pelanggan di landing page.
            </p>
        </div>
        <button
            wire:click="openModal"
            class="px-4 py-2 bg-amber-600 text-white rounded-md hover:bg-amber-700 flex items-center gap-2 transition shadow-md"
        >
            <i class="ri-add-line text-xl"></i>
            Tambah Testimoni
        </button>
    </div>

    @if (session("message"))
        <div
            class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center"
        >
            <i class="ri-checkbox-circle-line mr-2 text-xl"></i>
            {{ session("message") }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($testimonials as $testimonial)
            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col"
            >
                <div class="p-6 flex-grow">
                    <div class="flex items-center gap-4 mb-4">
                        <img
                            src="{{ $testimonial->client_image ?: "https://ui-avatars.com/api/?name=" . urlencode($testimonial->client_name) }}"
                            class="w-12 h-12 rounded-full object-cover border-2 border-amber-100"
                        />
                        <div>
                            <h3 class="font-bold text-gray-900 line-clamp-1">
                                {{ $testimonial->client_name }}
                            </h3>
                            <p class="text-xs text-amber-600 font-medium">
                                {{ $testimonial->client_role }}
                            </p>
                        </div>
                        <div class="ml-auto flex items-center text-amber-500">
                            <span class="text-sm font-bold mr-1">
                                {{ $testimonial->rating }}
                            </span>
                            <i class="ri-star-fill"></i>
                        </div>
                    </div>

                    <div class="relative">
                        <i
                            class="ri-double-quotes-l absolute -top-2 -left-2 text-gray-100 text-3xl z-0"
                        ></i>
                        <p
                            class="text-sm text-gray-600 italic relative z-10 leading-relaxed"
                        >
                            "{{ $testimonial->testimonial_text }}"
                        </p>
                    </div>
                </div>

                <div
                    class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between"
                >
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-medium text-gray-500">
                            Urutan: {{ $testimonial->sort_order }}
                        </span>
                        @if ($testimonial->is_active)
                            <span
                                class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-bold rounded-full uppercase"
                            >
                                Aktif
                            </span>
                        @else
                            <span
                                class="px-2 py-0.5 bg-gray-200 text-gray-600 text-[10px] font-bold rounded-full uppercase"
                            >
                                Nonaktif
                            </span>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button
                            wire:click="edit({{ $testimonial->id }})"
                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition"
                            title="Edit"
                        >
                            <i class="ri-edit-line"></i>
                        </button>
                        <button
                            wire:click="delete({{ $testimonial->id }})"
                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition"
                            title="Hapus"
                        >
                            <i class="ri-delete-bin-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div
                class="col-span-full py-12 text-center bg-gray-50 rounded-xl border-2 border-dashed border-gray-200"
            >
                <i class="ri-message-line text-4xl text-gray-300 mb-2"></i>
                <p class="text-gray-500">
                    Belum ada testimoni yang ditambahkan.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Modal Tambah/Edit --}}
    <div
        x-data
        x-show="$wire.showModal"
        x-cloak
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/40 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div
            class="w-full max-w-lg bg-white rounded-2xl shadow-2xl p-6 md:p-8"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            @click.stop
        >
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">
                    {{ $isEditMode ? "Edit Testimoni" : "Tambah Testimoni Baru" }}
                </h3>
                <button
                    wire:click="closeModal"
                    class="text-gray-400 hover:text-gray-600"
                >
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            <form wire:submit.prevent="save" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Pelanggan
                    </label>
                    <input
                        type="text"
                        wire:model="client_name"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="Misal: Budi Sudarsono"
                    />
                    @error("client_name")
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Peran / Jabatan
                        </label>
                        <input
                            type="text"
                            wire:model="client_role"
                            class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                            placeholder="Misal: Penikmat Kopi"
                        />
                        @error("client_role")
                            <p class="mt-1 text-xs text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Rating (1-5)
                        </label>
                        <select
                            wire:model.number="rating"
                            class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                        >
                            @for ($i=5; $i>=1; $i--)
                                <option value="{{ $i }}">
                                    {{ $i }} Bintang
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        URL Foto (Opsional)
                    </label>
                    <input
                        type="text"
                        wire:model="client_image"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="https://..."
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Isi Testimoni
                    </label>
                    <textarea
                        wire:model="testimonial_text"
                        rows="3"
                        class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                        placeholder="Apa kata pelanggan tentang toko Anda?"
                    ></textarea>
                    @error("testimonial_text")
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4 items-center">
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 mb-1"
                        >
                            Urutan Tampil
                        </label>
                        <input
                            type="number"
                            wire:model.number="sort_order"
                            class="w-full rounded-lg border-gray-300 focus:ring-amber-500 focus:border-amber-500"
                        />
                    </div>
                    <div class="flex items-center gap-2 pt-5">
                        <input
                            type="checkbox"
                            wire:model="is_active"
                            id="is_active"
                            class="rounded text-amber-600 focus:ring-amber-500"
                        />
                        <label
                            for="is_active"
                            class="text-sm text-gray-700 font-medium"
                        >
                            Aktif / Tampilkan
                        </label>
                    </div>
                </div>

                <div class="flex gap-3 mt-8">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="flex-1 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        class="flex-1 py-2.5 bg-amber-600 text-white rounded-lg font-medium hover:bg-amber-700 transition shadow-md shadow-amber-200"
                    >
                        {{ $isEditMode ? "Simpan Perubahan" : "Tambah Testimoni" }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Hapus --}}
    <div
        x-data
        x-show="$wire.showDeleteModal"
        x-cloak
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
            @click.stop
        >
            <div
                class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600"
            >
                <i class="ri-error-warning-line text-3xl"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">
                Hapus Testimoni?
            </h3>
            <p class="text-gray-600 mb-6">
                Tindakan ini tidak dapat dibatalkan.
            </p>
            <div class="flex gap-3">
                <button
                    wire:click="closeModal"
                    class="flex-1 py-2.5 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50 transition"
                >
                    Batal
                </button>
                <button
                    wire:click="confirmDelete"
                    class="flex-1 py-2.5 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition"
                >
                    Hapus
                </button>
            </div>
        </div>
    </div>
</div>
