<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cvCalismaSaatleriModel extends Model
{
    use HasFactory;
    protected $table = "cv_calismasaatleri";
    protected $fillable = [
        'cv_id',
        'calismaSaatleri',
    ];
}
