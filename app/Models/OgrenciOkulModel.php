<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OgrenciOkulModel extends Model
{
    use HasFactory;
    protected $table = "ogrenci_okul";
    protected $fillable = [
        'okul_id',
        'ogrenci_id',
        'sinif',
        'brans',
    ];
}
