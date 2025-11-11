<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Layout, Title, Computed};
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

new #[Layout("layouts.app")] #[Title("Reports")] class extends Component {
    public string $startDate = "";
    public string $endDate = "";
    public bool $showAllTime = false;
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

        // Dispatch event untuk memperbarui Chart.js
        $this->dispatch("report-updated", sales: $this->dailySalesData);
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

    public function exportPdf()
    {
        $startDate = $this->startDate;
        $endDate = $this->endDate;

        if ($this->showAllTime) {
            $firstTransaction = $this->dailySalesData()->first();
            $lastTransaction = $this->dailySalesData()->last();

            $startDate = $firstTransaction
                ? Carbon::parse($firstTransaction["date"])->format("Y-m-d")
                : now()->format("Y-m-d");
            $endDate = $lastTransaction
                ? Carbon::parse($lastTransaction["date"])->format("Y-m-d")
                : now()->format("Y-m-d");
        }

        $pdf = Pdf::loadView("pdf.report", [
            "reportData" => $this->reportData,
            "startDate" => $startDate,
            "endDate" => $endDate,
            "isAllTime" => $this->showAllTime,
        ]);

        $fileName = "laporan-penjualan-" . now()->format("Y-m-d") . ".pdf";

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $fileName);
    }
}; ?>

<div class="p-6 space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
            <p class="text-gray-600">
                Analisis performa penjualan dan statistik bisnis
            </p>
        </div>
        <button
            wire:click="exportPdf"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-75 cursor-wait"
            class="inline-flex cursor-pointer items-center px-4 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-all duration-200"
        >
            <svg
                wire:loading.remove
                wire:target="exportPdf"
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
            <svg
                wire:loading
                wire:target="exportPdf"
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
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
            <span wire:loading wire:target="exportPdf">Mengekspor...</span>
            <span wire:loading.remove wire:target="exportPdf">Export PDF</span>
        </button>
    </div>

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
                    <p class="text-2xl md:text-xl font-bold text-gray-900">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div
            class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-6"
        >
            <h3 class="text-lg font-semibold text-gray-900 mb-6">
                Grafik Penjualan Harian
            </h3>

            <div
                x-data="{
                    chart: null,
                    data: @js($this->dailySalesData),
                    error: null,
                    initChart() {
                        try {
                            const sales = this.data.map((item) => item.total)
                            const labels = this.data.map((item) => item.date)
                            const ctx = this.$refs.canvas.getContext('2d')
                            if (this.chart) {
                                this.chart.destroy()
                            }
                            this.chart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels: labels,
                                    datasets: [
                                        {
                                            label: 'Penjualan',
                                            data: sales,
                                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                            borderColor: 'rgb(59, 130, 246)',
                                            borderWidth: 2,
                                            fill: true,
                                            tension: 0.4,
                                            pointRadius: 4,
                                            pointHoverRadius: 6,
                                            pointBackgroundColor: 'rgb(59, 130, 246)',
                                            pointBorderColor: '#fff',
                                            pointBorderWidth: 2,
                                        },
                                    ],
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        legend: {
                                            display: false,
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                            padding: 12,
                                            titleFont: {
                                                size: 14,
                                            },
                                            bodyFont: {
                                                size: 13,
                                            },
                                            callbacks: {
                                                label: function (context) {
                                                    return (
                                                        'Rp ' +
                                                        context.parsed.y.toLocaleString('id-ID')
                                                    )
                                                },
                                            },
                                        },
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: function (value) {
                                                    return 'Rp ' + value.toLocaleString('id-ID')
                                                },
                                            },
                                            grid: {
                                                color: 'rgba(0, 0, 0, 0.05)',
                                            },
                                        },
                                        x: {
                                            grid: {
                                                display: false,
                                            },
                                        },
                                    },
                                },
                            })
                            this.error = null
                        } catch (e) {
                            this.error = e.message
                            console.error('Chart error:', e)
                        }
                    },
                    updateChart(newData) {
                        try {
                            const newSales = newData.map((item) => item.total)
                            const newLabels = newData.map((item) => item.date)
                            if (this.chart) {
                                this.chart.data.labels = newLabels
                                this.chart.data.datasets[0].data = newSales
                                this.chart.update()
                            }
                            this.error = null
                        } catch (e) {
                            this.error = e.message
                            console.error('Chart update error:', e)
                        }
                    },
                }"
                x-init="initChart()"
                @report-updated.window="data = $event.detail.sales; initChart()"
                wire:ignore
                class="relative h-96"
            >
                <canvas x-ref="canvas" class="w-full h-full"></canvas>

                <template x-if="error">
                    <div
                        class="absolute inset-0 flex items-center justify-center text-center text-red-600 bg-white/80 backdrop-blur-sm"
                    >
                        <p>
                            Error Chart:
                            <span x-text="error"></span>
                        </p>
                    </div>
                </template>

                <template x-if="!error && data.length === 0">
                    <div
                        class="absolute inset-0 flex items-center justify-center text-center text-gray-500 bg-white/80 backdrop-blur-sm"
                    >
                        <p>Tidak ada data penjualan untuk periode ini.</p>
                    </div>
                </template>
            </div>
        </div>

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
</div>
