<?php

namespace App\Repositories;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\MassAssignmentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class UserRepository
{
    private User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        try {
            return $this->model->all();
        } catch (QueryException $e) {
            throw new Exception($e->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function getById(int $id): ?User
    {
        try {
            return $this->model->find($id);
        } catch (ModelNotFoundException $e) {
            throw new Exception($e->getMessage(), 404);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function create(array $data): User
    {
        try {
            return $this->model->create($data);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function update(int $id, array $data): User
    {
        try {
            $user = $this->getById($id);
            $user->update($data);
            return $user->fresh();
        } catch (MassAssignmentException $e) {
            throw new Exception($e->getMessage(), 500);
        } catch (QueryException $e) {
            throw new Exception($e->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }

    public function delete(int $id): bool
    {
        try {
            $user = $this->getById($id);
            return $user->delete();
        } catch (QueryException $e) {
            throw new Exception($e->getMessage(), 500);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), 500);
        }
    }
}
