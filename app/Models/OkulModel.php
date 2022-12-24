<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OkulModel extends Model
{
    use HasFactory;
    protected $table = "okul";
    protected $fillable = [
        'ad',
    ];
}
