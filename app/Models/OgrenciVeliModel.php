<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OgrenciVeliModel extends Model
{
    use HasFactory;
    protected $table = "ogrenci_veli";
    protected $fillable = [
        'ogrenci_id',
        'veli_id',
    ];
}
