<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationDetail extends Model
{
    protected $fillable = [
        'evaluation_id',
        'criteria_id',
        'rating',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
