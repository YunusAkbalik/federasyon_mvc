<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $get)
 */
class OkulModel extends Model
{
    use HasFactory;
    protected $table = "okul";
    protected $fillable = [
        'ad',
    ];
}
