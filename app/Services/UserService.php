<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers(): Collection
    {
        return $this->userRepository->all();
    }

    public function getById(int $id): User
    {
        return $this->userRepository->getById($id);
    }

    public function createUser(array $requestData): User
    {
        $data = [
            'name' => $requestData['name'],
            'username' => $requestData['username'],
            'password' => Hash::make($requestData['password']),
            'phone' => $requestData['phone'],
            'role' => $requestData['role']
        ];
        return $this->userRepository->create($data);
    }

    public function updateUser(int $id, array $requestData): User
    {
        $data = [
            'name' => $requestData['name'],
            'username' => $requestData['username'],
            'phone' => $requestData['phone'],
            'role' => $requestData['role']
        ];
        return $this->userRepository->update($id, $data);
    }

    public function deleteUser(int $id): bool
    {
        return $this->userRepository->delete($id);
    }
}
