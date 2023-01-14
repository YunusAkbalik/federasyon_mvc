<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cvOncekiislerModel extends Model
{
    use HasFactory;
    protected $table = "cv_oncekiisler";
    protected $fillable = [
        'cv_id',
        'isler',
    ];
}
