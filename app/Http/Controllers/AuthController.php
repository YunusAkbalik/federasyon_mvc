<?php

namespace App\Http\Controllers;

use App\Models\cvCalismaSaatleriModel;
use App\Models\cvOncekiislerModel;
use App\Models\cvSertifikaModel;
use App\Models\IlModel;
use App\Models\kurumLogModel;
use App\Models\kurumUserModel;
use App\Models\LogModel;
use App\Models\OgrenciOkulModel;
use App\Models\OgrenciVeliModel;
use App\Models\ogretmenCvModel;
use App\Models\ogretmenPhotoModel;
use App\Models\OkulModel;
use App\Models\onePassesModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

            $newUser =  User::create(array_merge($request->all(), array(
                'onayli' => false,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($request->password),
                'ozel_id' => ozel_id_uret()
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
            return redirect()->route('giris_yap')->with("success", "Öğrenci kayıt işlemi başarılı");
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
            $newUser = User::create(array_merge($request->all(), [
                'onayli' => false,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($request->password),
                'ozel_id' => ozel_id_uret()
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
    #region Öğretmen
    public function ogretmen_kayit()
    {
        return view('ogretmen.register');
    }
    public function ogretmen_kayit_post(Request $request)
    {
        try {
            $rules = array(
                'tc_kimlik' => array('digits:11', 'required'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'gsm_no' => array('required', 'digits:10'),
                'email' => array('required'),
                'photo' => array('required'),
                'okul' => array('required'),
                'bolum' => array('required'),
                'mezun_tarihi' => array('required'),
                'sertifikalar' => array('required'),
                'oncekiisler' => array('required'),

            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
                'dogum_tarihi' => "Doğum Tarihi",
                'gsm_no' => "Telefon Numarası",
                'email' => "E-posta Adresi",
                'photo' => "Profil Fotoğrafı",
                'okul' => "Mezun Olduğunuz Okul",
                'bolum' => "Mezun Olduğunuz Bölüm",
                'mezun_tarihi' => "Mezun Olma Tarihiniz",
                'sertifikalar' => "Sertifikalarınız",
                'oncekiisler' => "Önceden Çalıştığınız Okullar",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            if (!$request->calismaSaati)
                throw new Exception("Lütfen çalışma saati belirleyin");
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
            $newUser = User::create(array_merge($request->all(), [
                'onayli' => false,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($request->password),
                'ozel_id' => ozel_id_uret()
            ]));
            $newUser->assignRole('Öğretmen');
            $photo = $request->file('photo');
            $photoName = Str::random() . "." . $photo->getClientOriginalExtension();
            $nameExist = true;
            while ($nameExist) {
                if (!(ogretmenPhotoModel::where('photo_path', $photoName)->first()))
                    $nameExist = false;
                else
                    $photoName = Str::random() . "." . $photo->getClientOriginalExtension();
            }
            $photo->move('uploads/teacher_photos', $photoName);
            ogretmenPhotoModel::create([
                'ogretmen_id' => $newUser->id,
                'photo_path' => $photoName
            ]);
            $cv = ogretmenCvModel::create(array_merge($request->all(), ['ogretmen_id' => $newUser->id]));
            $sertifikalar =  explode(",", $request->sertifikalar);
            foreach ($sertifikalar as $sertifika) {
                cvSertifikaModel::create([
                    'cv_id' => $cv->id,
                    'sertifika' => ucwords(trim($sertifika))
                ]);
            }
            $oncekiisler =  explode(",", $request->oncekiisler);
            foreach ($oncekiisler as $oncekiis) {
                cvOncekiislerModel::create([
                    'cv_id' => $cv->id,
                    'isler' => ucwords(trim($oncekiis))
                ]);
            }
            foreach ($request->calismaSaati as $saat) {
                if ($saat != 1 && $saat != 2 && $saat != 3)
                    throw new Exception("Lütfen çalışma saati belirtin");
                switch ($saat) {
                    case '1':
                        cvCalismaSaatleriModel::create([
                            'cv_id' => $cv->id,
                            'calismaSaatleri' => "Tam Zamanlı"
                        ]);
                        break;
                    case '2':
                        cvCalismaSaatleriModel::create([
                            'cv_id' => $cv->id,
                            'calismaSaatleri' => "Yarı Zamanlı"
                        ]);
                        break;
                    case '3':
                        cvCalismaSaatleriModel::create([
                            'cv_id' => $cv->id,
                            'calismaSaatleri' => "Uzaktan Eğitim"
                        ]);
                        break;
                }
            }
            return redirect()->route('giris_yap')->with('success', 'Kayıt işleminiz başarılı');
        } catch (Exception $exception) {
            return redirect()->back()->withInput($request->all())->withErrors($exception->getMessage());
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
                'sube' => $request->sube == "null" ? NULL : $request->sube,
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
            $one_pass = rand(100000, 999999);
            $newUser = User::create(array_merge($request->all(), [
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($one_pass),
                'ozel_id' => ozel_id_uret()
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
    #region Login/Logout
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
                $role = auth()->user()->getRoleNames()[0];
                $logText = "$role, $user->ad $user->soyad ($user->ozel_id) sisteme giriş yaptı";
                LogModel::create([
                    'kategori_id' => 1,
                    'logText' => $logText
                ]);

                if ($role == "Kurum Yetkilisi") {
                    $kurumlogText = "$user->ad $user->soyad ($user->ozel_id) sisteme giriş yaptı";
                    kurumLogModel::create([
                        'kategori_id' => 1,
                        'logText' => $kurumlogText,
                        'kurum_id' => get_current_kurum()->id
                    ]);
                }

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
        $role = auth()->user()->getRoleNames()[0];
        $logText = "$role, $user->ad $user->soyad ($user->ozel_id) sistemden çıkış yaptı";
        LogModel::create([
            'kategori_id' => 2,
            'logText' => $logText
        ]);

        if ($role == "Kurum Yetkilisi") {
            $kurumlogText = "$user->ad $user->soyad ($user->ozel_id) sistemden çıkış yaptı";
            kurumLogModel::create([
                'kategori_id' => 2,
                'logText' => $kurumlogText,
                'kurum_id' => get_current_kurum()->id
            ]);
        }
        Auth::logout();
        return redirect()->route('giris_yap');
    }
    #endregion


}
