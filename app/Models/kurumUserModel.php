<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kurumUserModel extends Model
{
    use HasFactory;
    protected $table = "kurum_user";
    protected $fillable = [
        'kurum_id',
        'user_id',
    ];
}
