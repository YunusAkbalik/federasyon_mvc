<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumLogKategoriModel extends Model
{
    use HasFactory;
    protected $table = "kurum_log_kategori";
    protected $fillable = [
        'ad',
        'icon',
    ];
}
