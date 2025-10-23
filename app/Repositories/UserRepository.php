<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserRepository
{
    /**
     * Create a new user.
     *
     * @param array<string, mixed> $data
     * @return \App\Models\User
     */
    public function create(array $data): User
    {
        try {
            return User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
            ]);
        } catch (Exception $e) {
            throw new Exception('Failed to create user', 500);
        }
    }
    public function findById(int $id): ?User
    {
        try {
            $user = User::findOrFail($id);
            return $user;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('User not found', 404);
        }
    }
    public function findByUsername(string $username): ?User
    {
        try {
            $user = User::where('username', $username)->first();
            return $user;
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('User not found', 404);
        }
    }
}
