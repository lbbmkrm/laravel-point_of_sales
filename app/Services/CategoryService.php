<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->all();
    }
}
