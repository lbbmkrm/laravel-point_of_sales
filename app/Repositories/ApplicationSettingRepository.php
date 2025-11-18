<?php

namespace App\Repositories;

use App\Models\ApplicationSetting;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ApplicationSettingRepository
{
    private ApplicationSetting $model;

    public function __construct(ApplicationSetting $model)
    {
        $this->model = $model;
    }

    /**
     * Get application settings (first row)
     * 
     * @return ApplicationSetting|null
     */
    public function get(): ?ApplicationSetting
    {
        try {
            return $this->model->first();
        } catch (Exception $e) {
            throw new Exception('Failed to get application settings: ' . $e->getMessage());
        }
    }

    /**
     * Get or create the singleton settings record
     * Always returns ID = 1
     * 
     * @return ApplicationSetting
     */
    public function getOrCreateSingleton(): ApplicationSetting
    {
        try {
            return $this->model->firstOrCreate(
                ['id' => 1],
                [
                    'shop_name' => 'Qio Coffee',
                    'shop_address' => 'Jl. Gatot Subroto, Medan',
                    'shop_phone' => '0812-3456-7890',
                    'shop_email' => 'hello@qiocoffee.com',
                    'shop_instagram' => '@qiocoffee',
                    'shop_facebook' => 'Qio Coffee Official',
                    'shop_website' => 'www.qiocoffee.com',
                    'currency' => 'IDR',
                    'currency_symbol' => 'Rp',
                    'tax_enabled' => true,
                    'tax_rate' => 0.10,
                    'tax_label' => 'PPN',
                    'service_charge_enabled' => false,
                    'service_charge_rate' => 0.05,
                    'landing_description' => 'Kedai kopi modern dengan suasana nyaman dan berbagai pilihan kopi terbaik di Bandung.',
                    'operating_hours' => '08:00 - 22:00',
                    'operating_days' => 'Senin - Minggu',
                    'timezone' => 'Asia/Jakarta',
                    'date_format' => 'd/m/Y',
                    'time_format' => 'H:i',
                ]
            );
        } catch (Exception $e) {
            throw new Exception('Failed to get or create settings: ' . $e->getMessage());
        }
    }

    /**
     * Update application settings
     * 
     * @param array $data
     * @return ApplicationSetting
     */
    public function update(array $data): ApplicationSetting
    {
        try {
            $setting = $this->getOrCreateSingleton();
            $setting->update($data);
            return $setting->fresh();
        } catch (Exception $e) {
            throw new Exception('Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Ensure only one record exists in the table
     * 
     * @return void
     * @throws Exception
     */
    public function ensureSingleRecord(): void
    {
        $count = $this->model->count();

        if ($count > 1) {
            throw new Exception("Multiple application settings records found. Only one record is allowed.");
        }

        if ($count === 0) {
            $this->getOrCreateSingleton();
        }
    }

    /**
     * Delete all records except the first one (cleanup method)
     * 
     * @return int Number of records deleted
     */
    public function cleanupDuplicates(): int
    {
        try {
            return $this->model->where('id', '>', 1)->delete();
        } catch (Exception $e) {
            throw new Exception('Failed to cleanup duplicates: ' . $e->getMessage());
        }
    }
}
