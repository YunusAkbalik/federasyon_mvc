<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\kurumOkulModel;
use App\Models\kurumUserModel;
use App\Models\ogrenciSinifModel;
use App\Models\sinifModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class kurumSinifController extends Controller
{
    public function index()
    {
        $kurum = get_current_kurum();
        $kurumOkullar = kurumOkulModel::where('kurum_id', $kurum->id)->join('okul', 'kurum_okul.okul_id', '=', 'okul.id')->orderBy('okul.ad')->with('okul')->get();
        if ($kurumOkullar->count() <= 0) {
            return redirect()->back()->withErrors("Kurumunuza ait okul bulunmuyor.");
        }
        return view('kurum.siniflar.index')->with([
            'kurum' => $kurum,
            'kurumOkullar' => $kurumOkullar,
        ]);
    }
    public function add(Request $request)
    {
        try {
            $rules = array(
                'okul_id' => array('required'),
                'yeniSinifAd' => array('required', 'string', 'max:30'),
            );
            $attributeNames = array(
                'Okul' => "Okul",
                'yeniSinifAd' => "Sınıf Adı",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'max' => ':attribute alanı maksimum :max karakter olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            $kurum = get_current_kurum();
            $okulExist = kurumOkulModel::where('kurum_id', $kurum->id)->where('okul_id', $request->okul_id)->first();
            if (!$okulExist)
                throw new Exception("Bir Hata Oluştu. Sayfayı yenileyin");
            $sinifExist = sinifModel::where('kurum_id', $kurum->id)->where('okul_id', $request->okul_id)->where('ad', $request->yeniSinifAd)->first();
            if ($sinifExist)
                throw new Exception("Bu sınıf okulunuzda mevcut");
            sinifModel::create([
                'kurum_id' => $kurum->id,
                'okul_id' => $request->okul_id,
                'ad' => $request->yeniSinifAd,
            ]);
            return response()->json(['message' => "$request->yeniSinifAd sınıfı oluşturuldu."]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function get(Request $request)
    {
        try {
            if (!$request->okul_id)
                throw new Exception("Bir hata oluştu");
            $kurum = get_current_kurum();
            if (!$kurum)
                throw new Exception("Bir hata oluştu");
            $okulKurum = kurumOkulModel::where('kurum_id', $kurum->id)->where('okul_id', $request->okul_id)->first();
            if (!$okulKurum)
                throw new Exception("Okul bilgisi alınamadı");
            $siniflar = sinifModel::where('kurum_id', $kurum->id)->where('okul_id', $request->okul_id)->orderBy('ad')->with('ogrenciler')->get();
            return response()->json(['data' => $siniflar]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function show(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Sınıf Bulunamadı");
            $sinif = sinifModel::find($request->id);
            if (!$sinif)
                throw new Exception("Sınıf Bulunamadı");
            $kurum = get_current_kurum();
            if ($sinif->kurum_id != $kurum->id)
                throw new Exception("Sınıf Bulunamadı");
            return view('kurum.siniflar.show')->with([
                'sinif' => $sinif
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    public function ogrenciEkleTc(Request $request)
    {
        try {
            if (!$request->tc)
                throw new Exception("Öğrenci Bulunamadı");
            // $ogrenci = User::where('tc_kimlik', $request->tc)->first();
            $ogrenci = User::where(function ($query) use ($request) {
                $query->where('tc_kimlik', '=',  $request->tc)
                    ->orWhere('ozel_id', '=', $request->tc);
            })->first();
            if (!$ogrenci)
                throw new Exception("Öğrenci Bulunamadı");
            if (!$ogrenci->hasRole("Öğrenci"))
                throw new Exception("Öğrenci Bulunamadı");
            if (!$request->sinif_id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $sinif = sinifModel::find($request->sinif_id);
            if (!$sinif)
                throw new Exception("Sınıf bilgisi alınamadı");
            $kurum = get_current_kurum();
            if ($sinif->kurum_id != $kurum->id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $ogrenciSinifExist = ogrenciSinifModel::where('sinif_id', $request->sinif_id)->where('ogrenci_id', $ogrenci->id)->first();
            if ($ogrenciSinifExist)
                throw new Exception("Öğrenci Zaten Bu Sınıfta");
            ogrenciSinifModel::create([
                'sinif_id' => $request->sinif_id,
                'ogrenci_id' => $ogrenci->id,
            ]);
            return response()->json(['message' => "Öğrenci $ogrenci->ad $ogrenci->soyad, sınıfa eklendi"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
}
