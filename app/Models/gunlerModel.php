<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gunlerModel extends Model
{
    use HasFactory;
    protected $table = "gunler";
    protected $fillable = [
        'ad',
    ];
}
