<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'committee_id',
        'name',
        'location',
        'formatted_address',     // nullable
        'contact_number',        // nullable
        'email',                 // nullable
        'owner_address',         // nullable
        'price_range',           // nullable
        'capacity',
        'description',           // nullable
        'status',
        'invitation_token'       // nullable
    ];

    // Optional: Laravel will cast nulls to strings, so if you want, define these casts
    protected $casts = [
        'formatted_address' => 'string',
        'contact_number' => 'string',
        'email' => 'string',
        'owner_address' => 'string',
        'price_range' => 'string',
        'description' => 'string',
        'invitation_token' => 'string',
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

    public function committee()
    {
        return $this->belongsTo(User::class, 'committee_id');
    }
}
