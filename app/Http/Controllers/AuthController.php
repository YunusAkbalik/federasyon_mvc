<?php

namespace App\Http\Controllers;

use App\Models\IlModel;
use App\Models\LogModel;
use App\Models\OgrenciOkulModel;
use App\Models\OgrenciVeliModel;
use App\Models\OkulModel;
use App\Models\onePassesModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    #region Öğrenci
    public function ogrenci_kayit()
    {
        $iller = IlModel::all();
        return view('ogrenci.register')->with([
            'iller' => $iller
        ]);
    }
    public function ogrenci_kayit_post(Request $request)
    {
        try {
            $rules = array(
                'tc_kimlik' => array('digits:11'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'il' => array('required'),
                'ilce' => array('required'),
                'okul' => array('required'),
                'sinif' => array('required', 'min:1', 'max:12'),
                'password' => array('required', 'numeric', 'digits:8'),
                'password_again' => array('required', 'numeric'),
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
                'password' => "Parola",
                'password_again' => "Parola Tekrar",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
                'numeric' => ':attribute alanı rakamlardan oluşmalıdır.',
                'min' => ':attribute alanı minimum :min olmalıdır.',
                'max' => ':attribute alanı maksimum :max olmalıdır.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            if (!($request->sinif >= 1 && $request->sinif <= 12))
                throw new Exception("Sınıfınız 1 ile 12 arasında olmalıdır.");
            if ($request->password != $request->password_again)
                throw new Exception("Parolanız uyuşmuyor.");
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
            $yearNow = date('y');
            $yearSecond = (string)$yearNow;
            $start = intval($yearSecond[1]) * 100000;
            $end = $start + 99999;
            $ozel_id_exist = true;
            $ozel_id = 0;
            while ($ozel_id_exist) {
                $ozel_id = rand($start, $end);
                if (!(User::where('ozel_id', $ozel_id)->first())) {
                    $ozel_id_exist = false;
                }
            }
            $newUser =  User::create(array_merge($request->all(), array(
                'onayli' => false,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($request->password),
                'ozel_id' => $ozel_id
            )));
            OgrenciOkulModel::create([
                'okul_id' => $okul->id,
                'ogrenci_id' => $newUser->id,
                'sinif' => $request->sinif,
                'sube' => $request->sube == "null" ? null : $request->sube,
                'brans' => $request->brans
            ]);
            $newUser->assignRole('Öğrenci');
            $logText = "Öğrenci, $newUser->ad $newUser->soyad ($newUser->tc_kimlik) sisteme kayıt oldu";
            LogModel::create(['kategori_id' => 3, 'logText' => $logText]);
            return redirect()->route('home')->with("success", "Öğrenci kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return redirect()->route('ogrenci_kayit')->withErrors($exception->getMessage());
        }
    }
    #endregion
    #region Veli
    public function veli_kayit()
    {
        return view('veli.register');
    }
    public function veli_kayit_post(Request $request)
    {
        try {
            $rules = array(
                'tc_kimlik' => array('digits:11', 'required'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'gsm_no' => array('required', 'digits:10'),
                'email' => array('required'),
            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
                'dogum_tarihi' => "Doğum Tarihi",
                'gsm_no' => "Telefon Numarası",
                'email' => "E-posta Adresi",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
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

            $yearNow = date('y');
            $yearSecond = (string)$yearNow;
            $start = intval($yearSecond[1]) * 100000;
            $end = $start + 99999;
            $ozel_id_exist = true;
            $ozel_id = 0;
            while ($ozel_id_exist) {
                $ozel_id = rand($start, $end);
                if (!(User::where('ozel_id', $ozel_id)->first())) {
                    $ozel_id_exist = false;
                }
            }
            $newUser = User::create(array_merge($request->all(), [
                'onayli' => false,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($request->password),
                'ozel_id' => $ozel_id
            ]));
            $newUser->assignRole('Veli');
            if ($request->ogrenci_tc) {
                $ogrenci = User::where('tc_kimlik', $request->ogrenci_tc)->first();
                if ($ogrenci) {
                    if ($ogrenci->hasRole('Öğrenci')) {
                        if (!(OgrenciVeliModel::where('ogrenci_id', $ogrenci->id)->first())) {
                            OgrenciVeliModel::create([
                                'ogrenci_id' => $ogrenci->id,
                                'veli_id' => $newUser->id,
                            ]);
                        }
                    }
                }
            }
            $logText = "Veli, $newUser->ad $newUser->soyad ($newUser->tc_kimlik) sisteme kayıt oldu";
            LogModel::create(['kategori_id' => 3, 'logText' => $logText]);
            return redirect()->route('home')->with("success", "Veli kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return redirect()->route('veli_kayit')->withErrors($exception->getMessage());
        }
    }

    #endregion
    #region Admin Hesap Oluştur
    public function ogrenciHesapOlustur()
    {
        $iller = IlModel::all();
        return view('admin.hesapOlustur.ogrenci')->with(array(
            'iller' => $iller
        ));
    }
    public function ogrenciHesapOlustur_post(Request $request)
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
            $yearNow = date('y');
            $yearSecond = (string)$yearNow;
            $start = intval($yearSecond[1]) * 100000;
            $end = $start + 99999;
            $ozel_id_exist = true;
            $ozel_id = 0;
            while ($ozel_id_exist) {
                $ozel_id = rand($start, $end);
                if (!(User::where('ozel_id', $ozel_id)->first())) {
                    $ozel_id_exist = false;
                }
            }
            $one_pass = rand(100000, 999999);
            $user = User::create(array_merge($request->all(), array(
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'ozel_id' => $ozel_id,
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
            $admin = auth()->user();
            $logText = "Admin $admin->ad $admin->soyad sisteme öğrenci ekledi ($user->ad $user->soyad ($user->ozel_id))";
            LogModel::create(['kategori_id' => 6, 'logText' => $logText]);
            onePassesModel::create([
                'user_id' => $user->id,
                'onePass' => $one_pass
            ]);
            return redirect()->route('admin_create_acc_ogrenci')->with("success", "Öğrenci kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
    public function veliHesapOlustur()
    {
        return view('admin.hesapOlustur.veli');
    }
    public function veliHesapOlustur_post(Request $request)
    {
        try {
            $rules = array(
                'tc_kimlik' => array('digits:11', 'required'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'gsm_no' => array('required', 'digits:10'),
                'email' => array('required'),
            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
                'dogum_tarihi' => "Doğum Tarihi",
                'gsm_no' => "Telefon Numarası",
                'email' => "E-posta Adresi",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
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
            $yearNow = date('y');
            $yearSecond = (string)$yearNow;
            $start = intval($yearSecond[1]) * 100000;
            $end = $start + 99999;
            $ozel_id_exist = true;
            $ozel_id = 0;
            while ($ozel_id_exist) {
                $ozel_id = rand($start, $end);
                if (!(User::where('ozel_id', $ozel_id)->first())) {
                    $ozel_id_exist = false;
                }
            }
            $one_pass = rand(100000, 999999);

            $newUser = User::create(array_merge($request->all(), [
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($one_pass),
                'ozel_id' => $ozel_id
            ]));
            $newUser->assignRole('Veli');
            if ($request->ogrenci_tc) {
                $ogrenci = User::where('tc_kimlik', $request->ogrenci_tc)->first();
                if ($ogrenci) {
                    if ($ogrenci->hasRole('Öğrenci')) {
                        if (!(OgrenciVeliModel::where('ogrenci_id', $ogrenci->id)->first())) {
                            OgrenciVeliModel::create([
                                'ogrenci_id' => $ogrenci->id,
                                'veli_id' => $newUser->id,
                            ]);
                        }
                    }
                }
            }
            $admin = auth()->user();
            $logText = "Admin $admin->ad $admin->soyad sisteme veli ekledi ($newUser->ad $newUser->soyad ($newUser->ozel_id))";
            LogModel::create(['kategori_id' => 7, 'logText' => $logText]);
            onePassesModel::create([
                'user_id' => $newUser->id,
                'onePass' => $one_pass
            ]);

            return redirect()->route('admin_create_acc_veli')->with("success", "Veli kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
    #endregion


    public function login()
    {
        return view('auth.index');
    }
    public function loginPost(Request $request)
    {
        try {
            $user = User::where(function ($query) use ($request) {
                $query->where('ozel_id', $request->login_id)
                    ->orWhere('gsm_no', $request->login_id);
            })->first();
            if (!$user)
                throw new Exception("Böyle bir kullanıcı yok");
            if ($user->ret)
                throw new Exception("Kayıt isteğiniz reddedilmiş.");
            if ($user->onayli == false && $user->ret == false)
                throw new Exception("Hesabınız onay bekliyor.");
            if (Auth::attempt(['id' => $user->id, 'password' => $request->login_password], true)) {
                $logText = "$user->ad $user->soyad ($user->ozel_id) sisteme giriş yaptı";
                LogModel::create([
                    'kategori_id' => 1,
                    'logText' => $logText
                ]);
                return redirect()->route('routeThisGuy');
            } else
                throw new Exception("ID veya Parola yanlış");
        } catch (Exception $exception) {
            return redirect()->route('giris_yap')->withErrors($exception->getMessage());
        }
    }
    public function logout()
    {
        $user = auth()->user();
        $logText = "$user->ad $user->soyad ($user->ozel_id) sistemden çıkış yaptı.";
        LogModel::create([
            'kategori_id' => 2,
            'logText' => $logText
        ]);
        Auth::logout();
        return redirect()->route('giris_yap');
    }
}
