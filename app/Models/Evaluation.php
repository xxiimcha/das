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
        'result',
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
        return $this->hasMany(EvaluationDetail::class, 'evaluation_id');
    }

}
