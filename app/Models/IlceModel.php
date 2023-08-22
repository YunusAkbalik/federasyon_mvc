<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $id)
 */
class IlceModel extends Model
{
    use HasFactory;
    protected $table = "ilce";
    protected $fillable = [
        'il_id',
        'ad',
    ];
}
