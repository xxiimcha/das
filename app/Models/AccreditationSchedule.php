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
    ];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }
}
