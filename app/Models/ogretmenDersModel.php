<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ogretmenDersModel extends Model
{
    use HasFactory;
    protected $table = "ogretmen_ders";
    protected $fillable = [
        'ogretmen_id',
        'ders_id',
    ];
    public function ogretmen()
    {
        return $this->hasOne(User::class, 'id', 'ogretmen_id');
    }
}
