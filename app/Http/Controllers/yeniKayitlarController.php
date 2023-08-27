<?php

namespace App\Http\Controllers;

use App\Models\IlceModel;
use App\Models\IlModel;
use App\Models\LogModel;
use App\Models\OgrenciOkulModel;
use App\Models\Okul;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class yeniKayitlarController extends Controller
{
    public function list()
    {
        $ogrenciler = User::role('Öğrenci')->where('onayli', false)->where('ret', false)->with('okul')->orderBy('created_at', 'ASC')->get();
        $veliler = User::role('Veli')->where('onayli', false)->where('ret', false)->orderBy('created_at', 'ASC')->get();
        return view('admin.yeni_kayitlar.list')->with([
            'ogrenciler' => $ogrenciler,
            'veliler' => $veliler,
        ]);
    }
    public function kontrolEt(Request $request)
    {
        try {
            if (!$request->ozel_id)
                throw new Exception("Hesap Bulunamadı");
            $user = User::where('ozel_id', $request->ozel_id)->with('okul')->first();
            if (!$user)
                throw new Exception("Hesap Bulunamadı");
            if ($user->onayli)
                throw new Exception("Kullanıcı onaylanmış");
            if ($user->ret)
                throw new Exception("Kullanıcı reddedilmiş");
            $iller = IlModel::all();
            $ilceler = null;
            $okullar = null;
            $user_il = null;

            if ($user->hasRole('Öğrenci')) {
                $ilce = IlceModel::find($user->okul->okulDetails->ilce_id);
                $ilceler = IlceModel::where('il_id', $ilce->il_id)->get();
                $okullar = Okul::where('ilce_id', $ilce->id)->get();
                $user_il = $ilce->il_id;
            }
            return view('admin.kontrol.index')->with(array(
                'user' => $user,
                'iller' => $iller,
                'ilceler' => $ilceler,
                'user_il' => $user_il,
                'okullar' => $okullar,

            ));
        } catch (Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function onayla(Request $request)
    {
        try {
            $rules = array(
                'tc' => array('digits:11', 'required'),
                'ad' => array('required'),
                'soyad' => array('required'),
            );
            $attributeNames = array(
                'tc' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            if (!$request->user_id)
                throw new Exception("Kullanıcı Bulunamadı");
            $user = User::find($request->user_id);
            if (!$user)
                throw new Exception("Kullanıcı Bulunamadı");
            if ($user->onayli)
                throw new Exception("Kullanıcı zaten onaylı");
            if ($user->ret)
                throw new Exception("Kullanıcı reddedilmiş");
            if ($user->hasRole('Öğrenci')) {
                if (!$request->okul)
                    throw new Exception("Öğrencinin okul bilgisini girin");
                if (!$request->sinif || !($request->sinif >= 1 && $request->sinif <= 12))
                    throw new Exception("Sınıf bilgisi alınamadı");
                $okul = Okul::find($request->okul);
                if (!$okul)
                    throw new Exception("Okul bilgisi bulunamadı");
            }

            $user->ad = $request->ad;
            $user->soyad = $request->soyad;
            $user->tc_kimlik = $request->tc;
            $user->gsm_no = $request->gsm_no;
            $user->email = $request->email;
            $user->onayli = true;
            $user->save();
            if ($user->hasRole('Öğrenci')) {
                $ogrenci_okul =  OgrenciOkulModel::where('ogrenci_id', $user->id)->first();
                $ogrenci_okul->okul_id = $request->okul;
                $ogrenci_okul->sinif = $request->sinif;
                $ogrenci_okul->sube = $request->sube;
                $ogrenci_okul->brans = $request->brans;
                $ogrenci_okul->save();
            }
            $admin = auth()->user();
            $logText = "Admin $admin->ad $admin->soyad , $user->ad $user->soyad ($user->ozel_id) adlı kullanıcıyı onayladı";
            LogModel::create([
                'kategori_id' => 4,
                'logText' => $logText
            ]);
            return redirect()->route('admin_yeni_kayitlar')->with('success', 'Kullanıcı Onaylandı');
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
    public function reddet(Request $request)
    {
        try {
            if (!$request->user_id)
                throw new Exception("Kullanıcı Bulunamadı");
            $user = User::find($request->user_id);
            if (!$user)
                throw new Exception("Kullanıcı Bulunamadı");
            if ($user->onayli)
                throw new Exception("Kullanıcı onaylı");
            if ($user->ret)
                throw new Exception("Kullanıcı zaten reddedilmiş");
            $user->ret = true;
            $user->ret_nedeni = $request->ret_nedeni;
            $user->save();

            $admin = auth()->user();
            $logText = "Admin $admin->ad $admin->soyad , $user->ad $user->soyad ($user->ozel_id) adlı kullanıcıyı reddetti";
            LogModel::create([
                'kategori_id' => 5,
                'logText' => $logText
            ]);
            return redirect()->route('admin_yeni_kayitlar')->with('success', 'Kullanıcı Reddedildi');
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
}
