<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ogrenciSinifModel extends Model
{
    use HasFactory;
    protected $table = "ogrenci_sinif";
    protected $fillable = [
        'sinif_id',
        'ogrenci_id',
    ];
}
