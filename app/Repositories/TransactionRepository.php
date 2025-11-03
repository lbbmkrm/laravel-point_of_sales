<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\RelationNotFoundException;

class TransactionRepository
{
    private Transaction $model;

    public function __construct(Transaction $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        try {
            return $this->model->all();
        } catch (Exception $e) {
            throw new Exception('Failed to get transactions', 500);
        }
    }

    public function getById(int $id): ?Transaction
    {
        try {
            $transaction = $this->model->with('transactionDetails')->findOrFail($id);
            return $transaction;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Transaction not found', 404);
        } catch (RelationNotFoundException $e) {
            throw new Exception('Failed to get transaction', 500);
        } catch (Exception $e) {
            throw new Exception('Failed to get transaction', 500);
        }
    }

    public function create(array $data): Transaction
    {
        try {
            return $this->model->create($data);
        } catch (MassAssignmentException $e) {
            throw new Exception($e->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function update(int $id, array $data): ?Transaction
    {
        try {
            $transaction = $this->model->findOrFail($id);
            $transaction->update($data);
            return $transaction;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('Transaction not found', 404);
        }
    }

    public function delete(Transaction $transaction): bool
    {
        try {
            return $transaction->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete transaction', 500);
        }
    }

    public function todayTransactions(): Collection
    {
        try {
            return $this->model->whereDate("created_at", Carbon::today())->get();
        } catch (QueryException $e) {
            throw new Exception('Failed to get transactions', 500);
        } catch (Exception $e) {
            throw new Exception('Failed to get transactions', 500);
        }
    }

    public function totalRevenue(?callable $callback = null): float
    {
        $query = $this->model->newQuery();

        if ($callback) {
            $callback($query);
        }

        return $query->sum('total_price');
    }

    public function getTransactionsBetweenDates(Carbon $start, Carbon $end): Collection
    {
        try {
            return $this->model->whereBetween('created_at', [$start, $end])->get();
        } catch (Exception $e) {
            throw new Exception('Failed to get transactions for date range', 500);
        }
    }

    public function getDailySalesSummary(Carbon $start, Carbon $end): Collection
    {
        try {
            return $this->model
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_price) as total'))
                ->whereBetween('created_at', [$start, $end])
                ->groupBy('date')
                ->orderBy('date', 'asc')
                ->get();
        } catch (Exception $e) {
            throw new Exception('Failed to get daily sales summary', 500);
        }
    }
}
