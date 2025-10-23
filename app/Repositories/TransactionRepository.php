<?php

namespace App\Repositories;

use Exception;
use App\Models\Transaction;
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
}
