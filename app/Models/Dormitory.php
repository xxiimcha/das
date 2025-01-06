<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'location',
        'price_range',
        'capacity',
        'description',
        'amenities',
        'images',
        'permits',
        'status',
    ];

    protected $casts = [
        'amenities' => 'array',
        'images' => 'array',
        'permits' => 'array',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
