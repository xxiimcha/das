<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Changed to user_id to match the migration
        'name',
        'location',
        'price_range',
        'capacity',
        'description',
        'status',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function amenities()
    {
        return $this->hasMany(Amenity::class);
    }

    public function images()
    {
        return $this->hasMany(DormitoryImage::class);
    }

    public function documents()
    {
        return $this->hasMany(DormitoryDocument::class);
    }

    public function accreditationSchedules()
    {
        return $this->hasMany(AccreditationSchedule::class, 'dormitory_id');
    }

}
