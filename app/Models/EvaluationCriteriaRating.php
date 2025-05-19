<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteriaRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'criteria_id',
        'rating',
    ];

    public function schedule()
    {
        return $this->belongsTo(AccreditationSchedule::class, 'schedule_id');
    }

    public function criteria()
    {
        return $this->belongsTo(Criteria::class, 'criteria_id');
    }
}
