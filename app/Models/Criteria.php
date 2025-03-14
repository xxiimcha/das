<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['criteria_name', 'values', 'status'];

    protected $casts = [
        'values' => 'array',
    ];


    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}
