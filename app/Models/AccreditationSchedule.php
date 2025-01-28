<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'dormitory_id',
        'evaluation_date',
        'status',
    ];

    /**
     * Cast attributes to native types.
     *
     * @var array
     */
    protected $casts = [
        'evaluation_date' => 'date', // Ensure it's treated as a date
    ];

    /**
     * Relationship: Schedule belongs to a dormitory.
     */
    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }
}
