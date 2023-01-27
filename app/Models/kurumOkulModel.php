<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumOkulModel extends Model
{
    use HasFactory;
    protected $table = "kurum_okul";
    protected $fillable = [
        'okul_id',
        'kurum_id',
    ];
    public function okul()
    {
        return $this->hasOne(OkulModel::class, 'id', 'okul_id');
    }
    public function siniflar()
    {
        return $this->hasMany(sinifModel::class, 'okul_id', 'okul_id')->with('ogrenciler');
    }
}
