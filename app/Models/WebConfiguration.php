<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
