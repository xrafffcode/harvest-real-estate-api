<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'property_id',
        'video_url',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
