<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\ProductRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(?string $category = null): Collection
    {
        return $this->productRepository->getAll($category);
    }

    public function createNewProduct(array $data): Product
    {
        Gate::authorize('create', Product::class);
        return $this->productRepository->create($data);
    }

    public function updateProduct(Product $product, array $data): bool
    {
        Gate::authorize('update', $product);
        return $this->productRepository->update($product, $data);
    }

    public function deleteProduct(Product $product): bool
    {
        Gate::authorize('delete', $product);
        return $this->productRepository->delete($product);
    }
}
