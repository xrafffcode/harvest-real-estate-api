<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Agent extends Model
{
    use HasFactory, UUID;
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'code',
        'name',
        'description',
        'specialization',
        'email',
        'phone_number',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'avatar',
    ];

    protected $appends = ['avatar_url'];




    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = Str::slug($this->name) . '-' . Str::random(6);
    }

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = Str::upper(Str::random(10));
    }

    public function setAvatarAttribute($value)
    {
        if ($value !== "undefined") {
            $this->attributes['avatar'] = $value->store('assets/agents', 'public');
        }
    }

    //    'avatar_url' => $this->avatar ? asset('storage/' . $this->avatar) : asset('images/avatar.jpg'),

    public function getAvatarUrlAttribute()
    {
        return $this->avatar ? asset('storage/' . $this->avatar) : asset('images/avatar.jpg');
    }
}
