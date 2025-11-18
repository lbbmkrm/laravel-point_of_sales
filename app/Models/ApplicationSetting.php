<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationSetting extends Model
{
    protected $table = 'application_settings';

    protected $fillable = [
        'shop_name',
        'shop_logo',
        'shop_address',
        'shop_phone',
        'shop_email',
        'shop_instagram',
        'shop_facebook',
        'shop_website',
        'currency',
        'currency_symbol',
        'tax_enabled',
        'tax_rate',
        'tax_label',
        'service_charge_enabled',
        'service_charge_rate',
        'landing_description',
        'operating_hours',
        'operating_days',
        'google_maps_url',
        'timezone',
        'date_format',
        'time_format',
    ];

    protected $casts = [
        'tax_enabled' => 'boolean',
        'service_charge_enabled' => 'boolean',
        'tax_rate' => 'float',
        'service_charge_rate' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get formatted tax rate (e.g., "10%")
     *
     * @return string
     */
    public function getFormattedTaxRateAttribute(): string
    {
        return number_format($this->tax_rate * 100, 0) . '%';
    }

    /**
     * Get formatted service charge rate (e.g., "5%")
     *
     * @return string
     */
    public function getFormattedServiceChargeRateAttribute(): string
    {
        return number_format($this->service_charge_rate * 100, 0) . '%';
    }

    /**
     * Boot method to ensure only one row exists
     */
    protected static function boot()
    {
        parent::boot();

        // Prevent creating multiple rows
        static::creating(function ($model) {
            if (self::count() > 0 && $model->id !== 1) {
                throw new \Exception('Only one application settings record is allowed.');
            }
        });
    }
}
