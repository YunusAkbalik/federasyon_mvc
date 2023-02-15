<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dersPlaniFilesModel extends Model
{
    use HasFactory;
    protected $table = "ders_plani_files";
    protected $fillable = [
        'ders_plani_id',
        'path',
        'extension',
    ];
    public function dersPlani()
    {
        return $this->hasOne(dersPlaniModel::class, 'id', 'ders_plani_id');
    }
}
