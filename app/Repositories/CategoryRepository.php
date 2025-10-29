<?php

namespace App\Repositories;

use App\Models\Category;
use Exception;
use Illuminate\Database\QueryException;

class CategoryRepository
{
    private Category $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        try {
            return $this->model->all();
        } catch (QueryException $e) {
            throw new Exception($e->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }
}
