<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $table = 'dormitory_amenities'; // Updated table name

    protected $fillable = [
        'dormitory_id',
        'name',
        'icon',
    ];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }
}
