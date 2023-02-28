<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\dersProgramiModel;
use App\Models\gunlerModel;
use App\Models\kurumDersModel;
use App\Models\kurumLogModel;
use App\Models\kurumOkulModel;
use App\Models\LogModel;
use App\Models\OgrenciOkulModel;
use App\Models\ogrenciSinifModel;
use App\Models\ogretmenDersModel;
use App\Models\ogretmenKurumModel;
use App\Models\OkulModel;
use App\Models\sinifModel;
use App\Models\User;
use App\Models\yoklamaModel;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ogretmenSinifController extends Controller
{
    public function list()
    {
        $siniflar = [];
        $ogretmenDers = ogretmenDersModel::where('ogretmen_id', auth()->user()->id)->with('dersProgrami')->get();
        foreach ($ogretmenDers as $sinif) {
            if ($sinif->dersProgrami->count() > 0) {
                foreach ($sinif->dersProgrami as $dersProgrami) {
                    $current_array = [$dersProgrami->sinif->id, $dersProgrami->sinif->ad];
                    if (!in_array($current_array, $siniflar))
                        array_push($siniflar, $current_array);
                }
            }
        }
        return view('ogretmen.sinif.list')->with([
            'siniflar' => $siniflar
        ]);
    }
    public function show(Request $r)
    {
        try {
            if (!$r->id)
                throw new Exception("Sınıf Bulunamadı");
            $sinif = sinifModel::find($r->id);
            if (!$sinif)
                throw new Exception("Sınıf Bulunamadı");
            $kurum = get_ogretmen_current_kurum();
            if ($sinif->kurum_id != $kurum->id)
                throw new Exception("Sınıf Bulunamadı");
            $yoklamaShow = false;
            if ($r->yoklama_tarih) {
                $time_input = strtotime($r->yoklama_tarih);
                $today = date("Y-m-d", $time_input);
                $yoklamaShow = true;
            } else
                $today = date("Y-m-d");
            $mon = new DateTime($today);
            $sun = new DateTime($today);
            $mon->modify('this week');
            $sun->modify('this week +6 day');
            $first_day_of_week = $mon->format("Y-m-d");
            $last_day_of_week = $sun->format("Y-m-d");
            $dersler = kurumDersModel::where('kurum_id', get_ogretmen_current_kurum()->id)->get();
            $gunler = gunlerModel::all();
            $dersProgrami = dersProgramiModel::where('sinif_id', $sinif->id)
                ->with('ders')
                ->with('ogretmen')
                ->orderBy('baslangic')
                ->get();
            $saatler = [];
            $dersGunleri = [];
            foreach ($dersProgrami as $key) {
                $string = $key->baslangic . "-" . $key->bitis;
                if (!in_array($string, $saatler))
                    array_push($saatler, $string);
            }
            $defaultDersID = 0;
            if ($dersler->count() > 0) {
                $forYoklamaDersProgrami = dersProgramiModel::where('sinif_id', $sinif->id)
                    ->where('ders_id', $r->yoklama_ders ? $r->yoklama_ders : $dersler->first()->id)
                    ->get();
                foreach ($forYoklamaDersProgrami as $key) {
                    if (!in_array($key->gun_id, $dersGunleri))
                        array_push($dersGunleri, $key->gun_id);
                }
                sort($dersGunleri);
                $defaultDersID = $dersler->first()->id;
            }
            if ($r->yoklama_ders) {
                $yoklama = yoklamaModel::with('ders_programi')
                    ->whereHas('ders_programi', function ($q) use ($r) {
                        return $q->where([
                            'kurum_id' => get_ogretmen_current_kurum()->id,
                            'ders_id' => $r->yoklama_ders
                        ]);
                    })
                    ->get();
            } else {
                $yoklama = yoklamaModel::with('ders_programi')
                    ->whereHas('ders_programi', function ($q) {
                        return $q->where('kurum_id', get_ogretmen_current_kurum()->id);
                    })->get();
            }


            $ogrenciler = ogrenciSinifModel::where('sinif_id', $sinif->id)->with('ogrenci')->with('okul')->get();
            $ogretmenler = ogretmenKurumModel::where('kurum_id', get_ogretmen_current_kurum()->id)->with('ogretmen')->get()->sortBy('ogretmen.ad');
            $kurumOkullar = kurumOkulModel::where('kurum_id', get_ogretmen_current_kurum()->id)->with('okul')->join('okul', 'kurum_okul.okul_id', '=', 'okul.id')->orderBy('okul.ad')->get();
            return view('ogretmen.sinif.show')->with([
                'sinif' => $sinif,
                'ogrenciler' => $ogrenciler,
                'kurumOkullar' => $kurumOkullar,
                'dersler' => $dersler,
                'gunler' => $gunler,
                'ogretmenler' => $ogretmenler,
                'dersProgrami' => $dersProgrami,
                'dersGunleri' => $dersGunleri,
                'saatler' => $saatler,
                'yoklama' => $yoklama,
                'first_day_of_week' => $first_day_of_week,
                'last_day_of_week' => $last_day_of_week,
                'yoklamaShow' => $yoklamaShow,
                'defaultDersID' => $defaultDersID,

            ]);
        } catch (Exception $ex) {
            return redirect()->route('ogretmen_sinif_list')->withErrors($ex->getMessage());
        }
    }
    public function getOgrenciler(Request $request)
    {
        try {
            if (!$request->id || !$request->sinif)
                throw new Exception("Okul bilgisi alınamadı");
            $okul = OkulModel::find($request->id);
            if (!$okul)
                throw new Exception("Okul bilgisi alınamadı");
            $sinif = sinifModel::find($request->sinif);
            if (!$sinif)
                throw new Exception("Sınıf bilgisi alınamadı");
            if ($sinif->kurum_id != get_ogretmen_current_kurum()->id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $siniftakiler = ogrenciSinifModel::where('sinif_id', $sinif->id)->get();
            $ogrenciler = OgrenciOkulModel::where('okul_id', $okul->id)->with('ogrenci')->orderBy('sube')->get();
            return response()->json(['data' => $ogrenciler, 'siniftakiler' => $siniftakiler]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function ogrenciEkleToplu(Request $request)
    {
        try {
            if (!$request->values)
                throw new Exception("Veri Alınamadı");
            $data = json_decode($request->values);
            $sinif = sinifModel::find($request->sinif);
            if (!$sinif)
                throw new Exception("Sınıf verisi alınamadı");
            if ($sinif->kurum_id != get_ogretmen_current_kurum()->id)
                throw new Exception("Sınıf verisi alınamadı");
            $logArray = array();
            foreach ($data as $key) {
                if ($key->durum) {
                    $exist = ogrenciSinifModel::where('sinif_id', $sinif->id)->where('ogrenci_id', $key->id)->first();
                    if (!$exist) {
                        $anlikOgrenci = User::find($key->id);
                        if ($anlikOgrenci->hasRole('Öğrenci')) {
                            ogrenciSinifModel::create([
                                'sinif_id' => $sinif->id,
                                'ogrenci_id' => $key->id
                            ]);
                            $stringHere = $anlikOgrenci->ad . " " . $anlikOgrenci->soyad . "(" . $anlikOgrenci->ozel_id . ")";
                            array_push($logArray, $stringHere);
                        }
                    }
                }
            }

            $logArray = implode(", ", $logArray);


            $logUser = auth()->user();
            $logText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' sınıfına öğrenciler ekledi : $logArray";
            LogModel::create(['kategori_id' => 14, 'logText' => $logText]);

            $kurumLogText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' sınıfına öğrenciler ekledi : $logArray";
            kurumLogModel::create(['kategori_id' => 9, 'logText' => $kurumLogText, 'kurum_id' => get_ogretmen_current_kurum()->id]);

            return response()->json(['message' => "Öğrenciler sınıfa eklendi"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
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
            $kurum = get_ogretmen_current_kurum();
            if ($sinif->kurum_id != $kurum->id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $ogrenciSinifExist = ogrenciSinifModel::where('sinif_id', $request->sinif_id)->where('ogrenci_id', $ogrenci->id)->first();
            if ($ogrenciSinifExist)
                throw new Exception("Öğrenci Zaten Bu Sınıfta");
            ogrenciSinifModel::create([
                'sinif_id' => $request->sinif_id,
                'ogrenci_id' => $ogrenci->id,
            ]);
            $logUser = auth()->user();
            $logText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), Öğrenci $ogrenci->ad $ogrenci->soyad ($ogrenci->ozel_id) sınıfa ekledi; '$sinif->ad'";
            LogModel::create(['kategori_id' => 14, 'logText' => $logText]);
            $kurumlogText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), Öğrenci $ogrenci->ad $ogrenci->soyad ($ogrenci->ozel_id) sınıfa ekledi; '$sinif->ad'";
            kurumLogModel::create(['kategori_id' => 9, 'logText' => $kurumlogText, 'kurum_id' => get_ogretmen_current_kurum()->id]);
            return response()->json(['message' => "Öğrenci $ogrenci->ad $ogrenci->soyad, sınıfa eklendi"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function ogrenciCikar(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Öğrenci bilgisi alınamadı");
            if (!$request->sinif)
                throw new Exception("Sınıf bilgisi alınamadı");
            $exist = ogrenciSinifModel::where('ogrenci_id', $request->id)->where('sinif_id', $request->sinif)->first();
            if (!$exist)
                throw new Exception("Öğrenci sınıfınızda değil");
            $sinif = sinifModel::find($request->sinif);
            if (!$sinif)
                throw new Exception("Sınıf bilgisi alınamadı");
            if ($sinif->kurum_id != get_ogretmen_current_kurum()->id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $user = User::find($request->id);
            if (!$user)
                throw new Exception("Öğrenci bilgisi alınamadı");
            $exist->delete();
            $logUser = auth()->user();
            $logText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' adlı sınıftan '$user->ad $user->soyad' öğrenciyi çıkardı";
            LogModel::create(['kategori_id' => 19, 'logText' => $logText]);
            $kurumLogText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' adlı sınıftan '$user->ad $user->soyad' öğrenciyi çıkardı";
            kurumLogModel::create(['kategori_id' => 14, 'logText' => $kurumLogText, 'kurum_id' => get_ogretmen_current_kurum()->id]);
            return response()->json(['message' => "Öğrenci '$user->ad $user->soyad' sınıftan kaldırıldı"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function getSiniflar(Request $request)
    {
        try {
            if (!$request->okul_id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $okul = OkulModel::find($request->okul_id);
            if (!$okul)
                throw new Exception("Okul bilgisi alınamadı");
            $kurum = get_ogretmen_current_kurum();
            if (!$kurum)
                throw new Exception("Kurum bilgisi alınamadı");
            $kurumOkulExist = kurumOkulModel::where([
                'okul_id' => $okul->id,
                'kurum_id' => $kurum->id,
            ]);
            if (!$kurumOkulExist)
                throw new Exception("Okul bilgisi alınamadı");
            $sinif = sinifModel::where([
                'kurum_id' => $kurum->id,
                'okul_id' => $okul->id,
            ])->get();
            return response()->json(['data' => $sinif]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
}
