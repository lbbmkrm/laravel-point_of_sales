<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Repositories\TransactionRepository;
use App\Repositories\TransactionDetailRepository;

class ReportService
{
    public function __construct(
        protected TransactionRepository $transactionRepo,
        protected TransactionDetailRepository $transactionDetailRepo
    ) {}

    public function generateReport(?string $startDate = null, ?string $endDate = null): array
    {
        $start = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $end = $endDate ? Carbon::parse($endDate)->endOfDay() : null;

        $transactions = $this->getTransactions($start, $end);
        $transactionDetails = $this->getDetails($start, $end);

        $totalSales = $transactions->sum('total_price');
        $totalTransactions = $transactions->count();

        return [
            'totalSales' => $totalSales,
            'totalTransactions' => $totalTransactions,
            'averagePerTransaction' => $totalTransactions > 0 ? $totalSales / $totalTransactions : 0,
            'totalProductsSold' => $transactionDetails->sum('quantity'),
            'dailySalesData' => $this->getDailySalesSummary($start, $end),
            'topSellingProducts' => $this->getTopSellingProducts($start, $end, 5),
        ];
    }

    protected function getTransactions(?Carbon $start, ?Carbon $end): Collection
    {
        return $start && $end
            ? $this->transactionRepo->getTransactionsBetweenDates($start, $end)
            : $this->transactionRepo->getAll(); // Gunakan method publik
    }

    protected function getDetails(?Carbon $start, ?Carbon $end): Collection
    {
        return $start && $end
            ? $this->transactionDetailRepo->getDetailsBetweenDates($start, $end)
            : $this->transactionDetailRepo->getAll(); // Gunakan method publik
    }

    protected function getDailySalesSummary(?Carbon $start, ?Carbon $end): Collection
    {
        if (!$start || !$end) {
            // Jika semua data → grup per bulan
            return $this->transactionRepo->getAll()
                ->groupBy(fn($t) => $t->created_at->format('Y-m'))
                ->map(fn($group, $period) => [
                    'date' => Carbon::createFromFormat('Y-m', $period)->format('M Y'),
                    'total' => $group->sum('total_price')
                ])
                ->sortKeys()
                ->values();
        }

        return $this->transactionRepo->getDailySalesSummary($start, $end);
    }

    protected function getTopSellingProducts(?Carbon $start, ?Carbon $end, int $limit = 5): Collection
    {
        $details = $start && $end
            ? $this->transactionDetailRepo->getDetailsBetweenDates($start, $end)
            : $this->transactionDetailRepo->getAll();

        return $details
            ->groupBy('product_id')
            ->map(fn($group) => [
                'product_id' => $group->first()->product_id,
                'total_sold' => $group->sum('quantity'),
                'total_revenue' => $group->sum(fn($d) => $d->quantity * $d->price),
                'product' => $group->first()->product,
            ])
            ->sortByDesc('total_sold')
            ->take($limit)
            ->values();
    }
}
