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
        'geldi',
        'tarih',
    ];
    public function ders_programi()
    {
        return $this->hasOne(dersProgramiModel::class, 'id', 'ders_programi_id');
    }
}
