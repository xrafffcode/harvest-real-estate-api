<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyAmenity extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'name',
    ];

    protected $appends = ['properties_count'];


    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_amenity_pivot');
    }



    public function getPropertiesCountAttribute()
    {
        return $this->properties->count();
    }
}
