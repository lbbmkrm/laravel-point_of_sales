<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;

class AuthService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user.
     *
     * @param array<string, mixed> $data
     * @return \App\Models\User
     */
    public function register(array $data): User
    {
        return $this->userRepository->create($data);
    }
}
