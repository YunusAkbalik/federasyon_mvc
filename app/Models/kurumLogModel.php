<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumLogModel extends Model
{
    use HasFactory;
    protected $table = "kurum_log";
    protected $fillable = [
        'kategori_id',
        'kurum_id',
        'logText',
    ];

    public function kategori()
    {
        return $this->hasOne(kurumLogKategoriModel::class, 'id', 'kategori_id');
    }
}
