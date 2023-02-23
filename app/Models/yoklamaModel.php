<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class yoklamaModel extends Model
{
    use HasFactory;
    protected $table = "yoklama";
    protected $fillable = [
        'ders_programi_id',
        'ogrenci_id',
        'durum_id',
        'tarih',
    ];
}
