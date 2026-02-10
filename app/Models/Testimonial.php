<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name',
        'client_role',
        'client_image',
        'testimonial_text',
        'rating',
        'is_active',
        'sort_order',
    ];
}
