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
}
