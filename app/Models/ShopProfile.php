<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProfile extends Model
{
    protected $table = 'shop_profiles';

    protected $fillable = [
        'name',
        'about',
        'logo',
        'address',
        'phone',
        'email',
        'instagram',
        'facebook',
        'tiktok',
        'landing_description',
        'operating_hours',
        'operating_days',
        'google_maps_url',
    ];
}
