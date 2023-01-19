<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumOgretmenTalepModel extends Model
{
    use HasFactory;
    protected $table = "kurum_ogretmen_talep";
    protected $fillable = [
        'kurum_id',
        'ogretmen_id',
    ];

    public function kurum()
    {
        return $this->hasOne(kurumModel::class, 'id', 'kurum_id');
    }
    public function kurum_owner()
    {
        return $this->hasOne(kurumUserModel::class, 'kurum_id', 'kurum_id')->with('user');
    }
}
