<?php

namespace App\Services;

use Exception;
use App\Models\Transaction;
use App\Repositories\TransactionDetailRepository;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    private TransactionRepository $transactionRepository;
    private TransactionDetailRepository $transactionDetailRepository;

    public function __construct(
        TransactionRepository $transactionRepository,
        TransactionDetailRepository $transactionDetailRepository,
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->transactionDetailRepository = $transactionDetailRepository;
    }

    public function getAllTransactions(): Collection
    {
        try {
            return $this->transactionRepository->getAll();
        } catch (Exception $e) {
            throw new Exception(
                $e->getMessage() ?? "Failed to get transactions",
                $e->getCode() ?? 500,
            );
        }
    }

    public function getTransactionById(int $id): ?Transaction
    {
        try {
            return $this->transactionRepository->getById($id);
        } catch (Exception $e) {
            throw new Exception(
                $e->getMessage() ?? "Failed to get transaction",
                $e->getCode() ?? 500,
            );
        }
    }

    public function createTransaction(array $data): Transaction
    {
        try {
            DB::beginTransaction();
            $newTransaction = $this->transactionRepository->create([
                "user_id" => $data["user_id"],
                "total_price" => $data["total_price"],
                "total_quantity" => $data["total_quantity"],
            ]);

            foreach ($data["transaction_details"] as $transactionDetail) {
                $this->transactionDetailRepository->create([
                    "transaction_id" => $newTransaction->id,
                    "product_id" => $transactionDetail["product_id"],
                    "quantity" => $transactionDetail["quantity"],
                    "price" => $transactionDetail["price"],
                ]);
            }

            DB::commit();
            return $newTransaction;
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception(
                $e->getMessage() ?? "Failed to create transaction",
                $e->getCode() ?? 500,
            );
        }
    }

    public function getTodayTransactions(): Collection
    {
        return $this->transactionRepository->todayTransactions();
    }


    public function getTodayRevenue(): float
    {
        return $this->transactionRepository->totalRevenue(function ($query) {
            $query->whereDate('created_at', Carbon::today());
        });
    }
    public function getWeeklyRevenue()
    {
        return $this->transactionRepository->totalRevenue(function ($query) {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        });
    }

    public function getMonthlyRevenue()
    {
        return $this->transactionRepository->totalRevenue(function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month);
        });
    }
}
