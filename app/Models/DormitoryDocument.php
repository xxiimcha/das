<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryDocument extends Model
{
    use HasFactory;

    protected $table = 'dormitory_documents';

    protected $fillable = ['dormitory_id', 'file_path'];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }
}
