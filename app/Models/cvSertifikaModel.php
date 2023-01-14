<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cvSertifikaModel extends Model
{
    use HasFactory;
    protected $table = "cv_sertifikalar";
    protected $fillable = [
        'cv_id',
        'sertifika',
    ];
}
