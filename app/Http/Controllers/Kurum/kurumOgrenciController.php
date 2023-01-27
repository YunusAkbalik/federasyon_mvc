<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\IlModel;
use App\Models\kurumOkulModel;
use App\Models\LogModel;
use App\Models\OgrenciOkulModel;
use App\Models\ogrenciSinifModel;
use App\Models\OgrenciVeliModel;
use App\Models\OkulModel;
use App\Models\onePassesModel;
use App\Models\sinifModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class kurumOgrenciController extends Controller
{
    public function hesapOlustur(Request $request)
    {
        $sinif = $request->sinif ? $request->sinif : null;
        $okul = null;
        if ($sinif != null) {
            $sinifModel = sinifModel::find($sinif);
            if (!$sinifModel) {
                $sinif = null;
                $okul = null;
            } else {
                if ($sinifModel->kurum_id != get_current_kurum()->id) {
                    $sinif = null;
                    $okul = null;
                }else{
                    $okul = $sinifModel->okul_id;
                }
            }
        }
        $iller = IlModel::all();
        $kurum = get_current_kurum();
        $kurumOkullar = kurumOkulModel::where('kurum_id', $kurum->id)->with('okul')->get();
        return view('kurum.hesapOlustur.ogrenci')->with(array(
            'iller' => $iller,
            'kurumOkullar' => $kurumOkullar,
            'sinif' => $sinif,
            'okulsecim' => $okul,
        ));
    }
    public function hesapOlustur_post(Request $request)
    {
        try {
            $rules = array(
                'tc_kimlik' => array('digits:11', 'required'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'il' => array('required'),
                'ilce' => array('required'),
                'okul' => array('required'),
                'sinif' => array('required'),
                'sube' => array('required'),
                'kurum_okul' => array('required'),
                'kurum_sinif' => array('required'),

            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
                'dogum_tarihi' => "Doğum Tarihi",
                'il' => "İl",
                'ilce' => "İlçe",
                'okul' => "Okul",
                'sinif' => "Sınıf",
                'sube' => "Şube",
                'kurum_okul' => "Kurum Okul",
                'kurum_sinif' => "Kurum Sınıf",

            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            if (!($request->sinif >= 1 && $request->sinif <= 12))
                throw new Exception("Sınıfınız 1 ile 12 arasında olmalıdır.");
            $userExist = User::where('tc_kimlik', $request->tc_kimlik)->first();
            if ($userExist)
                throw new Exception("Bu T.C Kimlik numarasına ait bir kullanıcı var.");
            if ($request->email) {
                $userExist = User::where('email', $request->email)->first();
                if ($userExist)
                    throw new Exception("Bu E-posta adresine ait bir kullanıcı var");
            }
            if ($request->gsm_no) {
                $userExist = User::where('gsm_no', $request->gsm_no)->first();
                if ($userExist)
                    throw new Exception("Bu telefon numarasına ait bir kullanıcı var");
            }
            $okul = OkulModel::find($request->okul);
            if (!$okul)
                throw new Exception("Okul bulunamadı");
            $kurum = get_current_kurum();
            $kurumOkulExist = kurumOkulModel::where('okul_id', $request->kurum_okul)->where('kurum_id', $kurum->id)->first();
            if (!$kurumOkulExist)
                throw new Exception("Kurumunuz bu okula hizmet vermiyor");
            $sinif = sinifModel::find($request->kurum_sinif);
            if (!$sinif)
                throw new Exception("Sınıf Bulunamadı");
            if ($sinif->kurum_id != $kurum->id)
                throw new Exception("Sınıf Bulunamadı");
            $one_pass = rand(100000, 999999);
            $user = User::create(array_merge($request->all(), array(
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'ozel_id' => ozel_id_uret(),
                'password' => bcrypt($one_pass)
            )));
            OgrenciOkulModel::create([
                'okul_id' => $okul->id,
                'ogrenci_id' => $user->id,
                'sinif' => $request->sinif,
                'sube' => $request->sube == "null" ? null : $request->sube,
                'brans' => $request->brans
            ]);
            $user->assignRole('Öğrenci');
            if ($request->veli_tc) {
                $veli = User::where('tc_kimlik', $request->veli_tc)->first();
                if ($veli) {
                    if ($veli->hasRole('Veli')) {
                        $veliOgrenciBaglantisi = OgrenciVeliModel::where('veli_id', $veli->id)->first();
                        if (!$veliOgrenciBaglantisi) {
                            OgrenciVeliModel::create(array(
                                'veli_id' => $veli->id,
                                'ogrenci_id' => $user->id
                            ));
                        }
                    }
                }
            }
            ogrenciSinifModel::create([
                'sinif_id' => $sinif->id,
                'ogrenci_id' => $user->id
            ]);
            $admin = auth()->user();
            $logText = "Kurum Yetkilisi $admin->ad $admin->soyad ($admin->ozel_id) sisteme öğrenci ekledi ($user->ad $user->soyad ($user->ozel_id))";
            LogModel::create(['kategori_id' => 6, 'logText' => $logText]);
            onePassesModel::create([
                'user_id' => $user->id,
                'onePass' => $one_pass
            ]);
            return redirect()->route('kurum_hesapOlustur_ogrenci')->with("success", "Öğrenci kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
}
