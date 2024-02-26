<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WebConfiguration extends Model
{
    use HasFactory, UUID;

    protected $fillable = [
        'title',
        'description',
        'email',
        'phone',
        'logo',
        'map',
        'address',
        'facebook',
        'instagram',
        'youtube',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'id' => 'string',
    ];

    public function setLogoAttribute($value)
    {
        if ($value != "undefined") {
            $this->attributes['logo'] = $value->store('assets/web-configurations', 'public');
        }
    }
}
