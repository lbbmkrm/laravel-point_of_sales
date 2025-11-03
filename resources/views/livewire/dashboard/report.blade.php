<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Computed};
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;

new #[Layout("layouts.app")] #[Title("Reports")] class extends Component {
    public string $startDate = "";
    public string $endDate = "";
    public bool $showAllTime = false; // Fitur baru
    public bool $showExportModal = false;
    public array $reportData = [];

    public function mount(ReportService $reportService)
    {
        if (Gate::denies("view-report", Auth::user())) {
            abort(403);
        }
        $this->startDate = Carbon::now()
            ->startOfMonth()
            ->format("Y-m-d");
        $this->endDate = Carbon::now()
            ->endOfMonth()
            ->format("Y-m-d");

        $this->generateReport($reportService);
    }

    public function generateReport(ReportService $reportService)
    {
        if (! $this->showAllTime) {
            $this->validate([
                "startDate" => "required|date",
                "endDate" => "required|date|after_or_equal:startDate",
            ]);
        }

        $this->reportData = $this->showAllTime
            ? $reportService->generateReport()
            : $reportService->generateReport($this->startDate, $this->endDate);
    }

    public function filterByDate(ReportService $reportService)
    {
        $this->generateReport($reportService);
    }

    public function updatedShowAllTime(ReportService $reportService)
    {
        $this->generateReport($reportService);
    }

    #[Computed]
    public function totalSales(): float
    {
        return $this->reportData["totalSales"] ?? 0;
    }
    #[Computed]
    public function totalTransactions(): int
    {
        return $this->reportData["totalTransactions"] ?? 0;
    }
    #[Computed]
    public function averagePerTransaction(): float
    {
        return $this->reportData["averagePerTransaction"] ?? 0;
    }
    #[Computed]
    public function totalProductsSold(): int
    {
        return $this->reportData["totalProductsSold"] ?? 0;
    }
    #[Computed]
    public function dailySalesData(): Collection
    {
        return $this->reportData["dailySalesData"] ?? collect();
    }
    #[Computed]
    public function topSellingProducts(): Collection
    {
        return $this->reportData["topSellingProducts"] ?? collect();
    }

    public function exportPDF()
    {
        $this->showExportModal = true;
    }

    public function closeExportModal()
    {
        $this->showExportModal = false;
    }
}; ?>

<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
            <p class="text-gray-600">
                Analisis performa penjualan dan statistik bisnis
            </p>
        </div>
        <button
            wire:click="exportPDF"
            class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-all duration-200"
        >
            <svg
                class="w-4 h-4 mr-2"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                />
            </svg>
            Export PDF
        </button>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
        <form wire:submit="filterByDate" class="space-y-4">
            <div class="flex items-center space-x-3">
                <input
                    type="checkbox"
                    wire:model.live="showAllTime"
                    id="showAllTime"
                    class="w-4 h-4 text-amber-600 border-gray-300 rounded focus:ring-amber-500"
                />
                <label
                    for="showAllTime"
                    class="text-sm font-medium text-gray-700 cursor-pointer"
                >
                    Tampilkan semua data (tanpa rentang waktu)
                </label>
            </div>

            <div
                class="grid grid-cols-1 md:grid-cols-2 gap-4"
                x-data="{ disabled: $wire.showAllTime }"
            >
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Mulai
                    </label>
                    <input
                        type="date"
                        wire:model.live="startDate"
                        :disabled="disabled"
                        class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                    />
                    @error("startDate")
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Akhir
                    </label>
                    <input
                        type="date"
                        wire:model.live="endDate"
                        :disabled="disabled"
                        class="w-full rounded-lg border-gray-300 px-3 py-2 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 disabled:bg-gray-100 disabled:cursor-not-allowed"
                    />
                    @error("endDate")
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button
                type="submit"
                class="px-6 py-2 bg-amber-600 text-white font-medium rounded-lg hover:bg-amber-700 transition-all duration-200"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>Terapkan Filter</span>
                <span wire:loading>Mohon tunggu...</span>
            </button>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                ["title" => "Total Penjualan", "value" => "Rp " . number_format($this->totalSales, 0, ",", "."), "color" => "blue"],
                ["title" => "Jumlah Transaksi", "value" => number_format($this->totalTransactions, 0, ",", "."), "color" => "green"],
                ["title" => "Rata-rata per Transaksi", "value" => "Rp " . number_format($this->averagePerTransaction, 0, ",", "."), "color" => "purple"],
                ["title" => "Produk Terjual", "value" => number_format($this->totalProductsSold, 0, ",", "."), "color" => "amber"],
            ];
        @endphp

        @foreach ($cards as $card)
            <div
                class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 flex justify-between items-center"
            >
                <div>
                    <p class="text-sm text-gray-600">{{ $card["title"] }}</p>
                    <p class="text-2xl font-bold text-gray-900">
                        {{ $card["value"] }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-lg bg-{{ $card["color"] }}-100"
                >
                    <svg
                        class="w-6 h-6 text-{{ $card["color"] }}-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"
                        ></path>
                    </svg>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Chart & Top Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Chart -->
        <div
            class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6"
        >
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                Grafik Penjualan Harian
            </h3>
            <div
                x-data="{
                    sales: @js($this->dailySalesData),
                    max: {{ $this->dailySalesData->max("total") ?: 1 }},
                }"
                class="h-64 flex items-end justify-center space-x-2"
            >
                <template x-for="(data, index) in sales" :key="index">
                    <div class="flex flex-col items-center">
                        <div
                            class="bg-blue-500 rounded-t-sm transition-all duration-300 hover:bg-blue-600 w-8"
                            :style="`height: ${(data.total / max * 12.5)}rem`"
                            :title="`Rp ${Number(data.total).toLocaleString('id-ID')}`"
                        ></div>
                        <span
                            class="text-xs text-gray-600 mt-2 rotate-[-45deg] origin-top-left"
                            x-text="data.date"
                        ></span>
                    </div>
                </template>

                <template x-if="sales.length === 0">
                    <div class="text-center text-gray-500 w-full">
                        <svg
                            class="w-16 h-16 mx-auto mb-4 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"
                            ></path>
                        </svg>
                        <p>Tidak ada data penjualan untuk periode ini</p>
                    </div>
                </template>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                Produk Terlaris
            </h3>
            <div class="space-y-4">
                @forelse ($this->topSellingProducts as $index => $item)
                    <div
                        wire:key="{{ $item->id ?? $index }}"
                        class="flex items-center justify-between bg-gray-50 p-3 rounded-lg"
                    >
                        <div class="flex items-center">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-semibold mr-3"
                            >
                                {{ $index + 1 }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">
                                    {{ $item["product"]["name"] ?? "Produk Dihapus" }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $item["total_sold"] }} terjual
                                </p>
                            </div>
                        </div>
                        <p class="font-semibold text-gray-900">
                            Rp
                            {{ number_format($item["total_revenue"], 0, ",", ".") }}
                        </p>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-8">
                        Belum ada data produk terjual
                    </p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if ($showExportModal)
        <div
            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        >
            <div
                class="bg-white rounded-2xl p-6 max-w-md w-full mx-4 shadow-xl"
            >
                <div class="text-center">
                    <div
                        class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"
                    >
                        <svg
                            class="w-8 h-8 text-green-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                            ></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        Export Berhasil
                    </h3>
                    <p class="text-gray-600 mb-6">
                        Fitur export PDF akan segera tersedia dalam update
                        mendatang.
                    </p>
                    <button
                        wire:click="closeExportModal"
                        class="w-full px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-medium rounded-lg transition-all duration-200"
                    >
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
