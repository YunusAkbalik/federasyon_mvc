<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sinifModel extends Model
{
    use HasFactory;
    protected $table = "sinif";
    protected $fillable = [
        'kurum_id',
        'okul_id',
        'ad',
    ];
}
