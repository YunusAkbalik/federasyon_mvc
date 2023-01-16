<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tc_kimlik',
        'ozel_id',
        'ad',
        'soyad',
        'dogum_tarihi',
        'kan_grubu',
        'gsm_no',
        'email',
        'onayli',
        'ret',
        'ret_nedeni',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function okul()
    {
        return $this->hasOne(OgrenciOkulModel::class, 'ogrenci_id', 'id')->with('okulDetails');
    }
    public function ogretmen_cv()
    {
        return $this->hasOne(ogretmenCvModel::class, 'ogretmen_id', 'id')->with('sertifikalar')->with('oncekiisler')->with('calismasaatleri');
    }
}
