<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'loc_city',
        'loc_latitude',
        'loc_longitude',
        'loc_address',
        'loc_state',
        'loc_zip',
        'loc_country',
        'price',
        'agent_id',
        'is_featured',
        'is_active',
        'is_sold',
        'is_rented',
        'offer_type',
        'slug',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price' => 'integer',
        'is_active' => 'boolean',
        'is_sold' => 'boolean',
        'is_rented' => 'boolean',
    ];

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function propertyAmenities()
    {
        return $this->belongsToMany(PropertyAmenity::class, 'property_amenity_pivot');
    }

    public function propertyCategories()
    {
        return $this->belongsToMany(PropertyCategory::class, 'property_category_pivot');
    }

    public function propertyTypes()
    {
        return $this->belongsToMany(PropertyType::class, 'property_type_pivot');
    }

    public function floorPlans()
    {
        return $this->hasMany(FloorPlan::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function propertyImages()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
