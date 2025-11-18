<?php

namespace App\Services;

use App\Models\ApplicationSetting;
use App\Repositories\ApplicationSettingRepository;
use Illuminate\Support\Facades\Cache;
use Exception;

class ApplicationSettingService
{
    private ApplicationSettingRepository $repository;

    public function __construct(ApplicationSettingRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get application settings with caching
     * 
     * @return ApplicationSetting
     */
    public function getSettings(): ApplicationSetting
    {
        return Cache::remember('app_settings', now()->addHours(24), function () {
            return $this->repository->getOrCreateSingleton();
        });
    }

    /**
     * Update application settings and clear cache
     * 
     * @param array $data
     * @return ApplicationSetting
     * @throws Exception
     */
    public function updateSettings(array $data): ApplicationSetting
    {
        try {
            $setting = $this->repository->update($data);
            $this->clearCache();
            return $setting;
        } catch (Exception $e) {
            throw new Exception('Failed to update application settings: ' . $e->getMessage());
        }
    }

    /**
     * Calculate tax amount for a given subtotal
     * 
     * @param float $subtotal
     * @return float
     */
    public function calculateTax(float $subtotal): float
    {
        $setting = $this->getSettings();

        if (!$setting->tax_enabled) {
            return 0;
        }

        return $subtotal * $setting->tax_rate;
    }

    /**
     * Calculate service charge for a given subtotal
     * 
     * @param float $subtotal
     * @return float
     */
    public function calculateServiceCharge(float $subtotal): float
    {
        $setting = $this->getSettings();

        if (!$setting->service_charge_enabled) {
            return 0;
        }

        return $subtotal * $setting->service_charge_rate;
    }

    /**
     * Calculate total with tax and service charge
     * 
     * @param float $subtotal
     * @return array
     */
    public function calculateTotal(float $subtotal): array
    {
        $tax = $this->calculateTax($subtotal);
        $serviceCharge = $this->calculateServiceCharge($subtotal);
        $total = $subtotal + $tax + $serviceCharge;

        return [
            'subtotal' => $subtotal,
            'tax' => $tax,
            'service_charge' => $serviceCharge,
            'total' => $total,
        ];
    }

    /**
     * Get tax label with formatted rate
     * 
     * @return string
     */
    public function getTaxLabel(): string
    {
        $setting = $this->getSettings();
        return "{$setting->tax_label} {$setting->formatted_tax_rate}";
    }

    /**
     * Check if tax is enabled
     * 
     * @return bool
     */
    public function isTaxEnabled(): bool
    {
        return $this->getSettings()->tax_enabled;
    }

    /**
     * Check if service charge is enabled
     * 
     * @return bool
     */
    public function isServiceChargeEnabled(): bool
    {
        return $this->getSettings()->service_charge_enabled;
    }

    /**
     * Clear settings cache
     * 
     * @return void
     */
    public function clearCache(): void
    {
        Cache::forget('app_settings');
    }

    /**
     * Ensure database integrity (only one record)
     * 
     * @return void
     */
    public function ensureIntegrity(): void
    {
        $this->repository->ensureSingleRecord();
    }
}
