<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DormitoryImage extends Model
{
    use HasFactory;

    protected $table = 'dormitory_images';

    protected $fillable = ['dormitory_id', 'image_path'];

    public function dormitory()
    {
        return $this->belongsTo(Dormitory::class);
    }
}
