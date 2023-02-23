<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yoklamaDurumModel extends Model
{
    use HasFactory;
    protected $table = "yoklama_durum";
    protected $fillable = [
        'durum',
    ];

}
