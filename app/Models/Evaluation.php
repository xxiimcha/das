<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'schedule_id',
        'evaluator_name',
        'evaluation_date',
    ];

    public function details()
    {
        return $this->hasMany(EvaluationDetail::class);
    }
}
