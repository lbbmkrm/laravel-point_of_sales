<?php

namespace App\Services;

use Exception;
use App\Models\Transaction;
use App\Repositories\TransactionDetailRepository;
use App\Repositories\TransactionRepository;
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
}
