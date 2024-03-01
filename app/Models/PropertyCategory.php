<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyCategory extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'icon',
        'slug',
    ];

    protected $hidden = [
        'pivot',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_category_pivot');
    }
}
