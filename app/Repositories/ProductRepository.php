<?php

namespace App\Repositories;

use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    private Product $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }
    public function getAll(): Collection
    {
        try {
            return $this->model->all();
        } catch (Exception $e) {
            throw new Exception('Failed to get products', 500);
        }
    }

    public function create(array $data): Product
    {
        try {
            return $this->model->create($data);
        } catch (Exception $e) {
            throw new Exception('Failed to create product', 500);
        }
    }

    public function update(Product $product, array $data): bool
    {
        try {
            return $product->update($data);
        } catch (Exception $e) {
            throw new Exception('Failed to update product', 500);
        }
    }

    public function delete(Product $product): bool
    {
        try {
            return $product->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to delete product', 500);
        }
    }
}
