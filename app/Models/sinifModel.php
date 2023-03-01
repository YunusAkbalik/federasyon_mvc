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
    public function ogrenciler()
    {
        return $this->hasMany(ogrenciSinifModel::class, 'sinif_id', 'id')->with('ogrenci');
    }
  
}
