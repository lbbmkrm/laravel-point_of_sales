<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        "image",
        "title",
        "description",
    ];

    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image);
    }
}
