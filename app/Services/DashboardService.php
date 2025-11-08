<?php

namespace App\Services;

use Carbon\Carbon;
use App\Repositories\TransactionRepository;
use Illuminate\Database\Eloquent\Collection;

class DashboardService
{
    private ProductService $productService;
    private TransactionService $transactionService;
    private TransactionRepository $transactionRepo;

    public function __construct(
        ProductService $productService,
        TransactionService $transactionService,
        TransactionRepository $transactionRepository
    ) {
        $this->productService = $productService;
        $this->transactionService = $transactionService;
        $this->transactionRepo = $transactionRepository;
    }

    public function getTodayTransactionsTotal(): int
    {
        return $this->transactionService->getTodayTransactions()->count();
    }
    public function getTodayRevenue(): int
    {
        return $this->transactionService->getTodayRevenue();
    }
    public function getWeeklyRevenue(): int
    {
        return $this->transactionService->getWeeklyRevenue();
    }

    public function getMonthlyRevenue(): int
    {
        return $this->transactionService->getMonthlyRevenue();
    }
    public function getTotalProducts(): int
    {
        return $this->productService->getAllProducts()->count();
    }

    public function getRecentTransactions(): Collection
    {
        return $this->transactionService->getAllTransactions()->sortByDesc("created_at")->take(5);
    }

    public function getWeeklySalesData(): Collection
    {
        return $this->transactionRepo->getDailySalesSummary(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
    }
}
