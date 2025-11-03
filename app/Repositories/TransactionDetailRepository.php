<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\RelationNotFoundException;

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

    public function getDetailsBetweenDates(Carbon $start, Carbon $end): Collection
    {
        try {
            return $this->model->whereHas('transaction', function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            })->get();
        } catch (Exception $e) {
            throw new Exception('Failed to get transaction details for date range', 500);
        }
    }

    public function getTopSellingProducts(Carbon $start, Carbon $end, int $limit = 5): Collection
    {
        try {
            return $this->model
                ->select(
                    'product_id',
                    DB::raw('SUM(quantity) as total_sold'),
                    DB::raw('SUM(quantity * transaction_details.price) as total_revenue')
                )
                ->with('product')
                ->whereHas('transaction', function ($query) use ($start, $end) {
                    $query->whereBetween('created_at', [$start, $end]);
                })
                ->groupBy('product_id')
                ->orderByDesc('total_sold')
                ->limit($limit)
                ->get();
        } catch (Exception $e) {
            throw new Exception('Failed to get top selling products', 500);
        }
    }
}
