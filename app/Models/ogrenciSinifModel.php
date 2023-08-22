<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 */
class ogrenciSinifModel extends Model
{
    use HasFactory;
    protected $table = "ogrenci_sinif";
    protected $fillable = [
        'sinif_id',
        'ogrenci_id',
    ];
    public function ogrenci()
    {
        return $this->hasOne(User::class, 'id', 'ogrenci_id');
    }
    public function okul()
    {
        return $this->hasOne(OgrenciOkulModel::class, 'ogrenci_id', 'ogrenci_id');
    }
    public function sinif()
    {
        return $this->hasOne(sinifModel::class, 'id', 'sinif_id');
    }
}
