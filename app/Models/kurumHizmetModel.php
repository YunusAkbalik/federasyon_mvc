<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumHizmetModel extends Model
{
    use HasFactory;
    protected $table = "kurum_hizmetler";
    protected $fillable = [
        'kurum_id',
        'hizmet',
    ];
}
