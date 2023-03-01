<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dersProgramiModel extends Model
{
    use HasFactory;
    protected $table = "ders_programi";
    protected $fillable = [
        'kurum_id',
        'ders_id',
        'gun_id',
        'baslangic',
        'bitis',
        'ogretmen_id',
        'sinif_id',
    ];
    public function ders()
    {
        return $this->hasOne(kurumDersModel::class, 'id', 'ders_id');
    }
    public function ogretmen()
    {
        return $this->hasOne(User::class, 'id', 'ogretmen_id');
    }
    public function sinif()
    {
        return $this->hasOne(sinifModel::class, 'id', 'sinif_id')->with('ogrenciler');
    }
    public function gun()
    {
        return $this->hasOne(gunlerModel::class, 'id', 'gun_id');
    }
    public function yoklama()
    {
        return $this->hasMany(yoklamaModel::class, 'ders_programi_id', 'id');
    }
}
