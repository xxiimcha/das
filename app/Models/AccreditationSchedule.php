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

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class, 'dormitory_id');
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'schedule_id');
    }

    public function ratings()
    {
        return $this->hasMany(EvaluationCriteriaRating::class, 'schedule_id');
    }
}
