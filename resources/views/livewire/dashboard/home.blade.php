<?php
use Livewire\Volt\Component;
use Livewire\Attributes\Title;
use Illuminate\Database\Eloquent\Collection;
use App\Services\DashboardService;

new #[Title("Dashboard")] class extends Component {
    public int $todayTransactions;
    public float $todayRevenue;
    public int $totalProducts;
    public Collection $recentTransactions;
    public float $weeklyRevenue;
    public float $monthlyRevenue;
    public Collection $weeklySalesData;

    public function mount(DashboardService $dashboardService): void
    {
        $this->todayTransactions = $dashboardService->getTodayTransactionsTotal();
        $this->todayRevenue = $dashboardService->getTodayRevenue();
        $this->totalProducts = $dashboardService->getTotalProducts();
        $this->recentTransactions = $dashboardService->getRecentTransactions();
        $this->weeklyRevenue = $dashboardService->getWeeklyRevenue();
        $this->monthlyRevenue = $dashboardService->getMonthlyRevenue();
        $this->weeklySalesData = $dashboardService->getWeeklySalesData();
    }
};
?>

<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Today's Transactions -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">
                        Transaksi Hari Ini
                    </p>
                    <p class="text-2xl md:text-xl font-bold text-gray-900">
                        {{ $this->todayTransactions }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center"
                >
                    <svg
                        class="w-6 h-6 text-green-600"
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
            </div>
        </div>

        <!-- Today's Revenue -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">
                        Pendapatan Hari Ini
                    </p>
                    <p class="text-2xl md:text-xl font-bold text-gray-900">
                        Rp
                        {{ number_format($this->todayRevenue, 0, ",", ".") }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"
                >
                    <svg
                        class="w-6 h-6 text-blue-600"
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
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">
                        Total Produk
                    </p>
                    <p class="text-2xl md:text-xl font-bold text-gray-900">
                        {{ $this->totalProducts }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center"
                >
                    <svg
                        class="w-6 h-6 text-amber-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                        ></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">
                        Pendapatan Bulan Ini
                    </p>
                    <p class="text-2xl md:text-xl font-bold text-gray-900">
                        Rp
                        {{ number_format($this->monthlyRevenue, 0, ",", ".") }}
                    </p>
                </div>
                <div
                    class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center"
                >
                    <svg
                        class="w-6 h-6 text-purple-600"
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
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a
                href="/cashier"
                class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200 group"
            >
                <div
                    class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-4"
                >
                    <svg
                        class="w-5 h-5 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"
                        ></path>
                    </svg>
                </div>
                <div>
                    <h4
                        class="font-medium text-gray-900 group-hover:text-green-700"
                    >
                        Kasir
                    </h4>
                    <p class="text-sm text-gray-600">
                        Proses transaksi penjualan
                    </p>
                </div>
            </a>

            <a
                href="/products"
                class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200 group"
            >
                <div
                    class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-4"
                >
                    <svg
                        class="w-5 h-5 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                        ></path>
                    </svg>
                </div>
                <div>
                    <h4
                        class="font-medium text-gray-900 group-hover:text-blue-700"
                    >
                        Kelola Produk
                    </h4>
                    <p class="text-sm text-gray-600">Tambah & edit menu kopi</p>
                </div>
            </a>

            <a
                href="/reports"
                class="flex items-center p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors duration-200 group"
            >
                <div
                    class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-4"
                >
                    <svg
                        class="w-5 h-5 text-white"
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
                </div>
                <div>
                    <h4
                        class="font-medium text-gray-900 group-hover:text-amber-700"
                    >
                        Laporan
                    </h4>
                    <p class="text-sm text-gray-600">Lihat laporan penjualan</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">
                Transaksi Terbaru
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            ID
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Kasir
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Total
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Waktu
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($this->recentTransactions as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"
                            >
                                #{{ $transaction->id }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                            >
                                {{ $transaction->user->name ?? "Unknown" }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900"
                            >
                                Rp
                                {{ number_format($transaction->total_price, 0, ",", ".") }}
                            </td>
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600"
                            >
                                {{ $transaction->created_at->format("d/m/Y H:i") }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-8 text-center text-gray-500"
                            >
                                Belum ada transaksi hari ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Performance Chart Placeholder -->
    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">
            Grafik Penjualan Minggu ini
        </h3>
        <div
            x-data="{
                chart: null,
                data: @js(data: $this->weeklySalesData),
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
                                        fill: false,
                                        tension: 0.1,
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
            }"
            x-init="initChart()"
            wire:ignore
            class="relative h-96"
        >
            <canvas x-ref="canvas" class="w-full h-full"></canvas>

            <template x-if="error">
                <div class="absolute inset-0 flex items-center justify-center">
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
</div>
