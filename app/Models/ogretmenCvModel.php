<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ogretmenCvModel extends Model
{
    use HasFactory;
    protected $table = "ogretmen_cv";
    protected $fillable = [
        'ogretmen_id',
        'okul',
        'bolum',
        'mezun_tarihi',
    ];
}
