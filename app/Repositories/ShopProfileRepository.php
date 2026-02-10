<?php

namespace App\Repositories;

use Exception;
use App\Models\ShopProfile;

class ShopProfileRepository
{
    private ShopProfile $shopProfile;

    public function __construct(ShopProfile $shopProfile)
    {
        $this->shopProfile = $shopProfile;
    }

    public function get(): ShopProfile
    {
        try {
            return $this->shopProfile->first();
        } catch (Exception $e) {
            throw new Exception('Failed to get shop profile: ' . $e->getMessage());
        }
    }

    public function getOrCreate(): ShopProfile
    {
        try {
            return $this->shopProfile->firstOrCreate(
                ['id' => 1],
                [
                    'name' => 'Qia Rongku Coffee',
                    'about' => 'Kedai kopi modern dengan suasana nyaman dan berbagai pilihan kopi terbaik di Medan. Kami menyajikan kopi berkualitas tinggi dengan cita rasa yang khas untuk memulai hari Anda dengan sempurna.',
                    'logo' => 'logo.png',
                    'address' => 'Jl. Gatot Subroto No. 123, Medan Petisah, Medan, Sumatera Utara 20112',
                    'phone' => '0812-3456-7890',
                    'email' => 'hello@qiarongkucoffee.com',
                    'instagram' => '@qiarongkucoffee',
                    'facebook' => 'QIA Rongku Coffee Official',
                    'tiktok' => '@qiarongkucoffee',
                    'landing_description' => 'Kedai kopi modern dengan suasana nyaman dan berbagai pilihan kopi terbaik di Medan. Kami menyajikan kopi berkualitas tinggi dengan cita rasa yang khas untuk memulai hari Anda dengan sempurna.',
                    'operating_hours' => '07:00 - 22:00',
                    'operating_days' => 'Senin - Minggu',
                    'google_maps_url' => 'https://maps.google.com/?q=QIA+Rongku+Coffee+Medan',
                    'google_rating' => 4.9,
                    'years_experience' => 3,
                ]
            );
        } catch (Exception $e) {
            throw new Exception('Failed to get or create shop profile: ' . $e->getMessage());
        }
    }

    public function update(array $data): ShopProfile
    {
        try {
            $shopProfile = $this->getOrCreate();
            $shopProfile->update($data);
            return $shopProfile->fresh();
        } catch (Exception $e) {
            throw new Exception('Failed to update shop profile: ' . $e->getMessage());
        }
    }
}
