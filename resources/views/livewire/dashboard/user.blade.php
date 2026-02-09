<?php

use App\Models\User;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title};

new #[Layout("layouts.app")] #[Title("Users")] class extends Component {
    public Collection $users;

    public bool $showUserModal = false;
    public bool $showDeleteModal = false;
    public bool $isEditMode = false;
    public ?User $userToDelete = null;
    public ?User $editingUser = null;

    // Form fields
    public string $name = "";
    public string $username = "";
    public string $phone = "";
    public string $role = "";
    public ?string $password = null;

    protected function rules(): array
    {
        $rules = [
            "name" => ["required", "string", "max:255"],
            "username" => [
                "required",
                "string",
                "max:255",
                "unique:users,username" .
                ($this->editingUser?->id ? "," . $this->editingUser->id : ""),
            ],
            "phone" => ["required", "string", "max:20"],
            "role" => ["required", "in:owner,cashier"],
        ];

        if (! $this->isEditMode) {
            $rules["password"] = ["required", "string", "min:8"];
        }

        return $rules;
    }

    public function mount(UserService $userService): void
    {
        $this->users = $userService->getAllUsers();
    }

    public function openModal(): void
    {
        $this->isEditMode = false;
        $this->resetForm();
        $this->showUserModal = true;
    }

    public function edit(User $user): void
    {
        $this->isEditMode = true;
        $this->editingUser = $user;

        $this->name = $user->name;
        $this->username = $user->username;
        $this->phone = $user->phone;
        $this->role = $user->role;
        $this->password = null; // Jangan isi password saat edit

        $this->showUserModal = true;
    }

    public function save(UserService $userService): void
    {
        try {
            $validated = $this->validate();

            if ($this->isEditMode) {
                // Jangan kirim password jika kosong
                $data = $validated;
                if (empty($data["password"])) {
                    unset($data["password"]);
                }
                $userService->updateUser($this->editingUser->id, $data);
                session()->flash(
                    "message",
                    "Data pengguna berhasil diperbarui.",
                );
            } else {
                $userService->createUser($validated);
                session()->flash(
                    "message",
                    "Pengguna baru berhasil ditambahkan.",
                );
            }

            $this->closeModal();
            $this->users = $userService->getAllUsers();
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash(
                "message",
                "Terjadi kesalahan saat menyimpan pengguna.",
            );
        }
    }

    public function delete(User $user): void
    {
        $this->userToDelete = $user;
        $this->showDeleteModal = true;
    }

    public function confirmDelete(UserService $userService): void
    {
        try {
            if ($this->userToDelete) {
                $userService->deleteUser($this->userToDelete->id);
                session()->flash("message", "Pengguna berhasil dihapus.");
                $this->users = $userService->getAllUsers();
            }
        } catch (\Exception $e) {
            session()->flash("message", "Gagal menghapus pengguna.");
        } finally {
            $this->showDeleteModal = false;
            $this->userToDelete = null;
        }
    }

    public function closeModal(): void
    {
        $this->showUserModal = false;
        $this->showDeleteModal = false;
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->reset([
            "name",
            "username",
            "phone",
            "role",
            "password",
            "editingUser",
            "isEditMode",
        ]);
    }
};
?>

<div class="container mx-auto p-4">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Manajemen Pengguna</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-700">Daftar Pengguna</h2>
            <button
                wire:click="openModal"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center gap-2 transition"
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
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6"
                    ></path>
                </svg>
                Tambah Pengguna
            </button>
        </div>

        @if (session("message"))
            <div
                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4"
            >
                {{ session("message") }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                            ID
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                            Nama
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                            Username
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                            Telepon
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                            Peran
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                        >
                            Dibuat
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
                        >
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-900">
                                {{ $user->id }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->username }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $user->phone }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === "owner" ? "bg-purple-100 text-purple-800" : "bg-indigo-100 text-indigo-800" }}"
                                >
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($user->created_at)->format("d M Y H:i") }}
                            </td>
                            <td
                                class="px-6 py-4 text-right text-sm font-medium space-x-2"
                            >
                                <button
                                    wire:click="edit({{ $user->id }})"
                                    class="text-indigo-600 hover:text-indigo-900 p-1 rounded-full hover:bg-indigo-100"
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
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                                        ></path>
                                    </svg>
                                </button>
                                <button
                                    wire:click="delete({{ $user->id }})"
                                    class="text-red-600 hover:text-red-900 p-1 rounded-full hover:bg-red-100"
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="7"
                                class="text-center py-8 text-gray-500"
                            >
                                Tidak ada data pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal Tambah/Edit User --}}
    <div
        x-data
        x-show="$wire.showUserModal"
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
            class="w-full max-w-2xl bg-white rounded-2xl shadow-2xl p-8"
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
                    {{ $isEditMode ? "Edit Pengguna" : "Tambah Pengguna Baru" }}
                </h3>
                <button
                    wire:click="closeModal"
                    class="text-gray-500 hover:text-gray-700 p-1 rounded-full hover:bg-gray-100"
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
                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap
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
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                ></path>
                            </svg>
                        </span>
                        <input
                            type="text"
                            wire:model="name"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="Masukkan nama lengkap"
                            required
                        />
                    </div>
                    @error("name")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Username
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
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                                ></path>
                            </svg>
                        </span>
                        <input
                            type="text"
                            wire:model="username"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="contoh: john.doe"
                            required
                        />
                    </div>
                    @error("username")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nomor Telepon
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
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                ></path>
                            </svg>
                        </span>
                        <input
                            type="tel"
                            wire:model="phone"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                            placeholder="08xxxxxxxxxx"
                            required
                        />
                    </div>
                    @error("phone")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Peran -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Peran
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
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                                ></path>
                            </svg>
                        </span>
                        <select
                            wire:model="role"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 appearance-none"
                            required
                        >
                            <option value="" disabled>Pilih peran</option>
                            <option value="owner">Owner</option>
                            <option value="cashier">Kasir</option>
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
                    @error("role")
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (hanya saat tambah) -->
                @if (! $isEditMode)
                    <div class="md:col-span-2">
                        <label
                            class="block text-sm font-medium text-gray-700 mb-2"
                        >
                            Password
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
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                    ></path>
                                </svg>
                            </span>
                            <input
                                type="password"
                                wire:model="password"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                placeholder="Minimal 8 karakter"
                                required
                            />
                        </div>
                        @error("password")
                            <p class="mt-1 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                @endif

                <!-- Buttons -->
                <div class="md:col-span-2 flex gap-4 pt-4">
                    <button
                        type="button"
                        wire:click="closeModal"
                        class="flex-1 py-3 border border-gray-300 text-gray-700 rounded-lg font-medium hover:bg-gray-50"
                    >
                        Batal
                    </button>
                    <button
                        type="submit"
                        wire:loading.attr="disabled"
                        wire:target="save"
                        class="flex-1 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 flex items-center justify-center gap-2"
                    >
                        <span wire:loading.remove wire:target="save">
                            {{ $isEditMode ? "Simpan Perubahan" : "Tambah Pengguna" }}
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

    {{-- Modal Hapus --}}
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
            <h3 class="text-xl font-bold text-gray-800 mb-2">
                Hapus Pengguna?
            </h3>
            <p class="text-gray-600 mb-6">
                Apakah Anda yakin ingin menghapus
                <span class="font-semibold">"{{ $userToDelete?->name }}"</span>
                ?
            </p>
            <div class="flex gap-3">
                <button
                    wire:click="closeModal"
                    class="flex-1 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50"
                >
                    Batal
                </button>
                <button
                    wire:click="confirmDelete"
                    wire:loading.attr="disabled"
                    wire:target="confirmDelete"
                    class="flex-1 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 flex items-center justify-center gap-2"
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
