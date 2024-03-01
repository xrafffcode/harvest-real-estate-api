<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorPlan extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'property_id',
        'sort',
        'title',
        'image',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
