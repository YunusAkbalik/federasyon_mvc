<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ogretmenCvModel extends Model
{
    use HasFactory;
    protected $table = "ogretmen_cv";
    protected $fillable = [
        'ogretmen_id',
        'okul',
        'bolum',
        'mezun_tarihi',
    ];
    public function sertifikalar()
    {
        return $this->hasMany(cvSertifikaModel::class, 'cv_id', 'id');
    }
    public function oncekiisler()
    {
        return $this->hasMany(cvOncekiislerModel::class, 'cv_id', 'id');
    }
    public function calismasaatleri()
    {
        return $this->hasMany(cvCalismaSaatleriModel::class, 'cv_id', 'id');
    }
}
