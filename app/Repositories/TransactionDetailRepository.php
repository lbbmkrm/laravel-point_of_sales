<?php

namespace App\Repositories;

use Exception;
use App\Models\TransactionDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\RelationNotFoundException;
use Illuminate\Database\Events\QueryExecuted;

class TransactionDetailRepository
{
    private TransactionDetail $model;

    public function __construct(TransactionDetail $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        try {
            return $this->model->all();
        } catch (QueryExecuted $e) {
            throw new Exception('Failed to get transaction details', 500);
        } catch (Exception $e) {
            throw new Exception('Failed to get transaction details', 500);
        }
    }

    public function getById(int $id): ?TransactionDetail
    {
        try {
            $transactionDetail = $this->model->findOrFail($id);
            return $transactionDetail;
        } catch (ModelNotFoundException $e) {
            throw new Exception('Transaction detail not found', 404);
        } catch (Exception $e) {
            throw new Exception('Failed to get transaction detail', 500);
        }
    }

    public function create(array $data): TransactionDetail
    {
        try {
            return $this->model->create($data);
        } catch (MassAssignmentException $e) {
            throw new Exception('Failed to create transaction detail', 500);
        } catch (RelationNotFoundException $e) {
            throw new Exception('Failed to create transaction detail', 500);
        } catch (Exception $e) {
            throw new Exception('Failed to create transaction detail', 500);
        }
    }

    public function delete(TransactionDetail $transactionDetail): bool
    {
        try {
            return $transactionDetail->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete transaction detail', 500);
        }
    }
}
