<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ogretmenPhotoModel extends Model
{
    use HasFactory;
    protected $table = "ogretmen_photo";
    protected $fillable = [
        'ogretmen_id',
        'photo_path',
    ];
}
