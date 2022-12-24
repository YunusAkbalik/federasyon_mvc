<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IlceModel extends Model
{
    use HasFactory;
    protected $table = "ilce";
    protected $fillable = [
        'il_id',
        'ad',
    ];
}
