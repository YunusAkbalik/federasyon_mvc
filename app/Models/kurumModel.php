<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumModel extends Model
{
    use HasFactory;
    protected $table = "kurumlar";
    protected $fillable = [
        'unvan',
        'telefon',
        'adres',
        'vergi_dairesi',
        'vergi_no',
        'yetkili_kisi',
        'yetkili_telefon',
        'wp_hatti',
    ];

    public function hizmetler()
    {
        return $this->hasMany(kurumHizmetModel::class, 'kurum_id', 'id');
    }
    public function yetkili()
    {
        return $this->hasOne(kurumUserModel::class, 'kurum_id', 'id')->with('user');
    }
}
