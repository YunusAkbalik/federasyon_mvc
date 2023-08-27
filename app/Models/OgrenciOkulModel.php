<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, $id)
 */
class OgrenciOkulModel extends Model
{
    use HasFactory;
    protected $table = "ogrenci_okul";
    protected $fillable = [
        'okul_id',
        'ogrenci_id',
        'sinif',
        'sube',
        'brans',
    ];

    public function okulDetails()
    {
        return $this->hasOne(Okul::class, 'id', 'okul_id');
    }
    public function ogrenci()
    {
        return $this->hasOne(User::class, 'id', 'ogrenci_id');
    }

}
