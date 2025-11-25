<?php

namespace App\Services;

use Exception;
use App\Models\ShopProfile;
use Illuminate\Support\Facades\Cache;
use App\Repositories\ShopProfileRepository;

class ShopProfileService
{
    private ShopProfileRepository $repository;

    public function __construct(ShopProfileRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getShopProfile()
    {
        return Cache::remember('shop_profile', now()->addHours(24), function () {
            return $this->repository->getOrCreate();
        });
    }

    public function updateShopProfile(array $data): ShopProfile
    {
        try {
            $shopProfile = $this->repository->update($data);
            Cache::forget('shop_profile');
            return $shopProfile;
        } catch (Exception $e) {
            throw new Exception('Failed to update shop profile: ' . $e->getMessage());
        }
    }
}
