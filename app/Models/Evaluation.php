<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'evaluator_name',
        'evaluation_date',
        'remarks',
    ];

    protected $casts = [
        'evaluation_date' => 'datetime',
    ];

    public function schedule()
    {
        return $this->belongsTo(AccreditationSchedule::class, 'schedule_id');
    }

    public function details()
    {
        return $this->hasMany(EvaluationCriteriaRating::class, 'evaluation_id');
    }


    public function criteria()
    {
        return $this->belongsToMany(Criteria::class, 'evaluation_details', 'evaluation_id', 'criteria_id')
                    ->withPivot('rating'); // Assuming there's a rating column
    }

}
