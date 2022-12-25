<?php

namespace App\Http\Controllers;

use App\Models\IlModel;
use App\Models\OgrenciOkulModel;
use App\Models\OkulModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
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
                'sinif' => array('required'),
                'brans' => array('required'),
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
                'brans' => "Branş",
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
            $okul = OkulModel::find($request->okul);
            if (!$okul)
                throw new Exception("Okul bulunamadı");

            $newUser =  User::create(array_merge($request->all(), array(
                'onayli' => false,
                'password' => bcrypt("0")
            )));
            OgrenciOkulModel::create([
                'okul_id' => $okul->id,
                'ogrenci_id' => $newUser->id,
                'sinif' => $request->sinif,
                'brans' => $request->brans
            ]);
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
                'tc_kimlik' => array('digits:11'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'gsm_no' => array('required', 'digits:10'),
            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
                'dogum_tarihi' => "Doğum Tarihi",
                'gsm_no' => "Telefon Numarası",
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
            $newUser = User::create(array_merge($request->all(),[
                'onayli' => false,
                'password' => bcrypt('0')
            ]));
            return redirect()->route('home')->with("success", "Veli kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return redirect()->route('veli_kayit')->withErrors($exception->getMessage());
        }
    }
    #endregion
}
