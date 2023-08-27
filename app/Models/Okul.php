<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @method static find(mixed $get)
 * @method static create(array $data)
 */
class Okul extends Model
{
    use HasFactory;

    protected $table = "okul";
    protected $guarded = [];
    public $timestamps = false;

    public function ilce(): HasOne
    {
        return $this->hasOne(IlceModel::class, 'id', 'ilce_id');
    }

    public function kurumlar(): HasMany
    {
        return $this->hasMany(kurumOkulModel::class, 'okul_id', 'id');
    }
}
