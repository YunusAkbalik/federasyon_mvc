<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumDersModel extends Model
{
    use HasFactory;
    protected $table = "kurum_ders";
    protected $fillable = [
        'kurum_id',
        'ad',
    ];
}
