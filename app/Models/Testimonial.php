<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'avatar',
        'testimonial',
    ];


    public function setAvatarAttribute($value)
    {
        if ($value !== "undefined") {
            $this->attributes['avatar'] = $value->store('assets/testimonials', 'public');
        }
    }

    public function getAvatarUrlAttribute()
    {
        return asset('storage/' . $this->avatar);
    }
}
