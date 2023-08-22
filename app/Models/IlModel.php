<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(mixed $get)
 */
class IlModel extends Model
{
    use HasFactory;
    protected $table = "il";
    protected $fillable = [
        'ad',
    ];


}
