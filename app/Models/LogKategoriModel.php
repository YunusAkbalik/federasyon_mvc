<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogKategoriModel extends Model
{
    use HasFactory;
    protected $table = "log_kategorileri";
    protected $fillable = [
        'ad',
        'icon',
    ];
}
