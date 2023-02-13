<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ogretmenKurumModel extends Model
{
    use HasFactory;
    protected $table = "ogretmen_kurum";
    protected $fillable = [
        'ogretmen_id',
        'kurum_id',
    ];
    public function kurum()
    {
        return $this->hasOne(kurumModel::class, 'id', 'kurum_id');
    }
    public function ders()
    {
        return $this->hasOne(ogretmenDersModel::class, 'ogretmen_id', 'ogretmen_id');
    }
    public function ogretmen()
    {
        return $this->hasOne(User::class, 'id', 'ogretmen_id');
    }
}
