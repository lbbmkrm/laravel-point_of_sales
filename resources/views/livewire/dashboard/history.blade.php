<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Computed, Url};
use Livewire\WithPagination;
use App\Models\Transaction;
use Carbon\Carbon;

new #[Layout("layouts.app")] #[Title("Transaction History")] class extends
    Component
{
    use WithPagination;

    #[Url(as: "q", keep: true)]
    public string $search = "";

    #[Url(as: "start", keep: true)]
    public string $startDate = "";

    #[Url(as: "end", keep: true)]
    public string $endDate = "";

    public bool $showDetailModal = false;
    public ?Transaction $selectedTransaction = null;

    public function mount()
    {
        if (! $this->startDate && ! $this->endDate && ! $this->search) {
            $this->setFilterRange("month");
        }
    }

    #[Computed]
    public function isFilterActive(): bool
    {
        return ! empty($this->search) ||
            $this->startDate !==
                Carbon::now()
                    ->startOfMonth()
                    ->format("Y-m-d") ||
            $this->endDate !==
                Carbon::now()
                    ->endOfMonth()
                    ->format("Y-m-d");
    }

    public function setFilterRange(string $range)
    {
        switch ($range) {
            case "today":
                $this->startDate = Carbon::today()->format("Y-m-d");
                $this->endDate = Carbon::today()->format("Y-m-d");
                break;
            case "week":
                $this->startDate = Carbon::now()
                    ->startOfWeek()
                    ->format("Y-m-d");
                $this->endDate = Carbon::now()
                    ->endOfWeek()
                    ->format("Y-m-d");
                break;
            case "month":
                $this->startDate = Carbon::now()
                    ->startOfMonth()
                    ->format("Y-m-d");
                $this->endDate = Carbon::now()
                    ->endOfMonth()
                    ->format("Y-m-d");
                break;
        }
        $this->resetPage();
    }

    #[Computed]
    public function transactions()
    {
        $query = Transaction::with([
            "user",
            "transactionDetails.product.category",
        ])->orderBy("created_at", "desc");

        if ($this->search) {
            $query->where(function ($q) {
                $q->where("id", "like", "%{$this->search}%")
                    ->orWhereHas("user", function ($qu) {
                        $qu->where("name", "like", "%{$this->search}%");
                    })
                    ->orWhereHas("transactionDetails.product", function ($qp) {
                        $qp->where("name", "like", "%{$this->search}%");
                    });
            });
        }

        if ($this->startDate) {
            $query->whereDate("created_at", ">=", $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate("created_at", "<=", $this->endDate);
        }

        return $query->paginate(10);
    }

    public function viewDetails($id)
    {
        $this->selectedTransaction = Transaction::with([
            "user",
            "transactionDetails.product.category",
        ])->find($id);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedTransaction = null;
    }

    public function resetFilters()
    {
        $this->reset(["search"]);
        $this->setFilterRange("month");
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }
}; ?>

<div class="p-4 md:p-6 space-y-6 min-h-screen">
    {{-- Header --}}
    <div
        class="flex flex-col md:flex-row md:items-center justify-between gap-4"
    >
        <div>
            <h1 class="text-xl md:text-2xl font-semibold text-gray-800">
                Riwayat Transaksi
            </h1>
            <p class="text-sm text-gray-500">
                Lihat dan kelola semua riwayat transaksi penjualan.
            </p>
        </div>

        <div class="flex items-center gap-2">
            @if ($this->isFilterActive)
                <span
                    class="hidden md:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800"
                >
                    Filter Aktif
                </span>
            @endif

            <button
                wire:click="resetFilters"
                @class([
                    "px-4 py-2 text-sm font-medium rounded-lg transition-all",
                    "text-amber-700 bg-amber-50 border border-amber-200" =>
                        $this->isFilterActive,
                    "text-gray-600 bg-white border border-gray-300 hover:bg-gray-50" => ! $this->isFilterActive,
                ])
            >
                Reset Filter
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="space-y-4">
        {{-- Quick Filters --}}
        <div class="flex flex-wrap gap-2">
            <button
                wire:click="setFilterRange('today')"
                class="px-3 py-1.5 text-xs font-medium rounded-full border transition {{ $startDate === date("Y-m-d") && $endDate === date("Y-m-d") ? "bg-amber-600 border-amber-600 text-white" : "bg-white border-gray-300 text-gray-600 hover:border-amber-500 hover:text-amber-500" }}"
            >
                Hari Ini
            </button>
            <button
                wire:click="setFilterRange('week')"
                class="px-3 py-1.5 text-xs font-medium rounded-full border transition {{ $startDate === Carbon::now()->startOfWeek()->format("Y-m-d") ? "bg-amber-600 border-amber-600 text-white" : "bg-white border-gray-300 text-gray-600 hover:border-amber-500 hover:text-amber-500" }}"
            >
                Minggu Ini
            </button>
            <button
                wire:click="setFilterRange('month')"
                class="px-3 py-1.5 text-xs font-medium rounded-full border transition {{ $startDate === Carbon::now()->startOfMonth()->format("Y-m-d") ? "bg-amber-600 border-amber-600 text-white" : "bg-white border-gray-300 text-gray-600 hover:border-amber-500 hover:text-amber-500" }}"
            >
                Bulan Ini
            </button>
        </div>

        {{-- Search & Date Filter --}}
        <div
            class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex flex-col lg:flex-row gap-4 lg:items-center"
        >
            <div class="flex-1 relative">
                <div
                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"
                >
                    <i class="ri-search-line text-gray-400"></i>
                </div>
                <input
                    type="text"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari ID, Kasir, atau Nama Produk..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition text-sm"
                />
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                <div class="w-full sm:w-auto flex items-center gap-2">
                    <input
                        type="date"
                        wire:model.live="startDate"
                        class="w-full sm:w-auto py-2 px-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition text-sm"
                    />
                    <span class="text-gray-500 text-xs shrink-0">s/d</span>
                    <input
                        type="date"
                        wire:model.live="endDate"
                        class="w-full sm:w-auto py-2 px-3 border border-gray-300 rounded-lg focus:ring-amber-500 focus:border-amber-500 transition text-sm"
                    />
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table --}}
    <div
        class="overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-100"
    >
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-gray-700">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th
                            class="px-4 md:px-6 py-4 text-left font-medium text-gray-500 uppercase tracking-wider"
                        >
                            ID
                        </th>
                        <th
                            class="px-4 md:px-6 py-4 text-left font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Waktu
                        </th>
                        <th
                            class="px-4 md:px-6 py-4 text-left font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell"
                        >
                            Kasir
                        </th>
                        <th
                            class="px-4 md:px-6 py-4 text-center font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell"
                        >
                            Item
                        </th>
                        <th
                            class="px-4 md:px-6 py-4 text-right font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Total Harga
                        </th>
                        <th
                            class="px-4 md:px-6 py-4 text-center font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($this->transactions as $trx)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td
                                class="px-4 md:px-6 py-4 font-medium text-amber-600"
                            >
                                #{{ $trx->id }}
                            </td>
                            <td class="px-4 md:px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col">
                                    <span class="font-medium text-gray-900">
                                        {{ $trx->created_at->translatedFormat("d M Y") }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $trx->created_at->format("H:i") }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-4 md:px-6 py-4 hidden sm:table-cell">
                                <span class="capitalize">
                                    {{ $trx->user->name }}
                                </span>
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-center hidden md:table-cell"
                            >
                                {{ $trx->total_quantity }}
                            </td>
                            <td
                                class="px-4 md:px-6 py-4 text-right font-bold text-gray-900"
                            >
                                <span
                                    class="text-xs font-normal text-gray-400 mr-0.5"
                                >
                                    Rp
                                </span>
                                {{ number_format($trx->total_price, 0, ",", ".") }}
                            </td>
                            <td class="px-4 md:px-6 py-4 text-center">
                                <button
                                    wire:click="viewDetails({{ $trx->id }})"
                                    class="p-2 text-amber-600 hover:bg-amber-100 rounded-lg transition-colors border border-transparent hover:border-amber-200"
                                    title="Lihat Detail"
                                >
                                    <i class="ri-eye-line text-lg"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="6"
                                class="px-6 py-12 text-center text-gray-500"
                            >
                                <div
                                    class="flex flex-col items-center justify-center"
                                >
                                    <i
                                        class="ri-history-line text-4xl text-gray-300 mb-2"
                                    ></i>
                                    <p>
                                        Tidak ada riwayat transaksi yang
                                        ditemukan.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $this->transactions->links() }}
    </div>

    {{-- Improved Detail Modal --}}
    <div
        x-show="$wire.showDetailModal"
        x-cloak
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[60] flex items-end sm:items-center justify-center p-0 sm:p-4 bg-black/60 backdrop-blur-sm"
        @keydown.escape.window="$wire.closeDetailModal()"
    >
        <div
            @click.stop
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-full sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-full sm:translate-y-0 sm:scale-95"
            class="bg-white rounded-t-3xl sm:rounded-2xl shadow-2xl w-full sm:max-w-2xl max-h-[95vh] sm:max-h-[90vh] flex flex-col overflow-hidden"
        >
            {{-- Modal Header --}}
            <div
                class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50 flex-shrink-0"
            >
                <div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900">
                        Detail #{{ $selectedTransaction?->id }}
                    </h3>
                    <p
                        class="text-[10px] md:text-xs text-gray-500 uppercase tracking-wider font-semibold"
                    >
                        {{ $selectedTransaction?->created_at->translatedFormat("d M Y • H:i") }}
                        WIB
                    </p>
                </div>
                <button
                    @click="$wire.closeDetailModal()"
                    class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-full transition-colors"
                >
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="p-4 md:p-6 overflow-y-auto flex-1 space-y-6">
                {{-- Quick Info Card --}}
                <div class="grid grid-cols-2 gap-3">
                    <div
                        class="p-3 bg-gray-50 border border-gray-100 rounded-2xl"
                    >
                        <p
                            class="text-[10px] text-gray-400 uppercase font-bold mb-1"
                        >
                            Kasir
                        </p>
                        <p class="text-sm font-semibold text-gray-900 truncate">
                            {{ $selectedTransaction?->user->name }}
                        </p>
                    </div>
                    <div
                        class="p-3 bg-green-50 border border-green-100 rounded-2xl"
                    >
                        <p
                            class="text-[10px] text-green-600 uppercase font-bold mb-1"
                        >
                            Status
                        </p>
                        <p
                            class="text-sm font-semibold text-green-700 flex items-center gap-1"
                        >
                            <i class="ri-checkbox-circle-fill"></i>
                            Selesai
                        </p>
                    </div>
                </div>

                {{-- Responsive Items Table --}}
                <div class="space-y-3">
                    <h4 class="text-sm font-bold text-gray-700 px-1">
                        Rincian Menu
                    </h4>
                    <div
                        class="border border-gray-100 rounded-2xl overflow-hidden shadow-sm"
                    >
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left font-bold text-gray-600 text-[11px] uppercase tracking-wider"
                                        >
                                            Produk
                                        </th>
                                        <th
                                            class="px-3 py-3 text-center font-bold text-gray-600 text-[11px] uppercase tracking-wider"
                                        >
                                            Qty
                                        </th>
                                        <th
                                            class="px-3 py-3 text-right font-bold text-gray-600 text-[11px] uppercase tracking-wider"
                                        >
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-gray-100 bg-white"
                                >
                                    @if ($selectedTransaction)
                                        @foreach ($selectedTransaction->transactionDetails as $detail)
                                            <tr>
                                                <td class="px-4 py-3">
                                                    <div
                                                        class="font-bold text-gray-900 text-sm"
                                                    >
                                                        {{ $detail->product->name }}
                                                    </div>
                                                    <div
                                                        class="text-[10px] text-amber-600 font-medium font-Rubik"
                                                    >
                                                        {{ $detail->product->category->name ?? "-" }}
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-3 py-3 text-center font-medium"
                                                >
                                                    {{ $detail->quantity }}
                                                </td>
                                                <td
                                                    class="px-4 py-3 text-right"
                                                >
                                                    <div
                                                        class="text-gray-900 font-bold"
                                                    >
                                                        <span
                                                            class="text-[10px] font-normal text-gray-400 mr-0.5"
                                                        >
                                                            Rp
                                                        </span>
                                                        {{ number_format($detail->price * $detail->quantity, 0, ",", ".") }}
                                                    </div>
                                                    <div
                                                        class="text-[10px] text-gray-400"
                                                    >
                                                        @
                                                        {{ number_format($detail->price, 0, ",", ".") }}
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div
                class="p-5 border-t border-gray-100 bg-white sm:bg-gray-50 flex items-center justify-between flex-shrink-0"
            >
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">
                        Total Akhir
                    </p>
                    <div class="text-2xl font-black text-amber-600">
                        <span class="text-sm font-bold mr-0.5">Rp</span>
                        {{ number_format($selectedTransaction?->total_price ?? 0, 0, ",", ".") }}
                    </div>
                </div>
                <button
                    @click="$wire.closeDetailModal()"
                    class="px-8 py-3 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition shadow-lg shadow-gray-200"
                >
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>
