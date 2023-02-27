<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\dersProgramiModel;
use App\Models\gunlerModel;
use App\Models\kurumDersModel;
use App\Models\kurumLogModel;
use App\Models\kurumModel;
use App\Models\kurumOkulModel;
use App\Models\kurumUserModel;
use App\Models\LogModel;
use App\Models\ogrenciSinifModel;
use App\Models\ogretmenKurumModel;
use App\Models\OkulModel;
use App\Models\sinifModel;
use App\Models\User;
use App\Models\yoklamaModel;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use stdClass;

class kurumSinifController extends Controller
{
    public function index(Request $r)
    {
        $okulExist = false;
        $okul = null;
        if ($r->okul) {
            $okul = OkulModel::find($r->okul);
            if ($okul) {
                $kurumOkulExist = kurumOkulModel::where([
                    'kurum_id' => get_current_kurum()->id,
                    'okul_id' => $okul->id
                ])->first();
                if ($kurumOkulExist) {
                    $okulExist = true;
                    $siniflar = sinifModel::where([
                        'kurum_id' => get_current_kurum()->id,
                        'okul_id' => $okul->id
                    ])
                        ->with('ogrenciler')
                        ->get();
                }
            }
        }
        $kurum = get_current_kurum();
        $kurumOkullar = kurumOkulModel::where('kurum_id', $kurum->id)->join('okul', 'kurum_okul.okul_id', '=', 'okul.id')->orderBy('okul.ad')->with('okul')->get();
        if ($kurumOkullar->count() <= 0) {
            return redirect()->route('kurum_okul_index')->withErrors("Kurumunuza ait okul bulunmuyor.");
        }
        if (!$okulExist) {
            $kurumOkul = kurumOkulModel::where('kurum_id', get_current_kurum()->id)->first();
            $okul = OkulModel::find($kurumOkul->okul_id);
            if (!$okul)
                return redirect()->route('kurum_okul_index')->withErrors("Okul Bulunamadı.");
            $siniflar = sinifModel::where([
                'kurum_id' => get_current_kurum()->id,
                'okul_id' => $okul->id
            ])
                ->with('ogrenciler')
                ->get();
        }
        return view('kurum.siniflar.index')->with([
            'kurum' => $kurum,
            'kurumOkullar' => $kurumOkullar,
            'okulExist' => $okulExist,
            'okul' => $okul,
            'siniflar' => $siniflar,
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
            $okul = OkulModel::find($request->okul_id);
            sinifModel::create([
                'kurum_id' => $kurum->id,
                'okul_id' => $request->okul_id,
                'ad' => $request->yeniSinifAd,
            ]);


            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), '$okul->ad' okuluna '$request->yeniSinifAd' adlı sınıfı açtı";
            LogModel::create(['kategori_id' => 13, 'logText' => $logText]);

            $kurumlogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), '$okul->ad' adlı okula '$request->yeniSinifAd' adlı sınıfı açtı";
            kurumLogModel::create([
                'kategori_id' => 8,
                'logText' => $kurumlogText,
                'kurum_id' => get_current_kurum()->id,
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
            $yoklamaShow = false;
            if ($request->yoklama_tarih) {
                $time_input = strtotime($request->yoklama_tarih);
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

            $dersler = kurumDersModel::where('kurum_id', get_current_kurum()->id)->get();
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
                    ->where('ders_id', $request->yoklama_ders ? $request->yoklama_ders : $dersler->first()->id)
                    ->get();
                foreach ($forYoklamaDersProgrami as $key) {
                    if (!in_array($key->gun_id, $dersGunleri))
                        array_push($dersGunleri, $key->gun_id);
                }
                sort($dersGunleri);
                $defaultDersID = $dersler->first()->id;
            }


            if ($request->yoklama_ders) {
                $yoklama = yoklamaModel::with('ders_programi')
                    ->whereHas('ders_programi', function ($q) use ($request) {
                        return $q->where([
                            'kurum_id' => get_current_kurum()->id,
                            'ders_id' => $request->yoklama_ders
                        ]);
                    })
                    ->get();
            } else {
                $yoklama = yoklamaModel::with('ders_programi')
                    ->whereHas('ders_programi', function ($q) {
                        return $q->where('kurum_id', get_current_kurum()->id);
                    })->get();
            }



            $ogrenciler = ogrenciSinifModel::where('sinif_id', $sinif->id)->with('ogrenci')->with('okul')->get();
            $ogretmenler = ogretmenKurumModel::where('kurum_id', get_current_kurum()->id)->with('ogretmen')->get()->sortBy('ogretmen.ad');
            $kurumOkullar = kurumOkulModel::where('kurum_id', get_current_kurum()->id)->with('okul')->join('okul', 'kurum_okul.okul_id', '=', 'okul.id')->orderBy('okul.ad')->get();
            return view('kurum.siniflar.show')->with([
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
            return redirect()->route('kurum_sinif_index')->withErrors($ex->getMessage());
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
            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), Öğrenci $ogrenci->ad $ogrenci->soyad ($ogrenci->ozel_id) sınıfa ekledi; '$sinif->ad'";
            LogModel::create(['kategori_id' => 14, 'logText' => $logText]);


            $kurumlogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), Öğrenci $ogrenci->ad $ogrenci->soyad ($ogrenci->ozel_id) sınıfa ekledi; '$sinif->ad'";
            kurumLogModel::create(['kategori_id' => 9, 'logText' => $kurumlogText, 'kurum_id' => get_current_kurum()->id]);
            return response()->json(['message' => "Öğrenci $ogrenci->ad $ogrenci->soyad, sınıfa eklendi"]);
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
            $kurum = get_current_kurum();
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
    public function ogrenciEkleToplu(Request $request)
    {
        try {
            if (!$request->values)
                throw new Exception("Veri Alınamadı");
            $data = json_decode($request->values);
            $sinif = sinifModel::find($request->sinif);
            if (!$sinif)
                throw new Exception("Sınıf verisi alınamadı");
            if ($sinif->kurum_id != get_current_kurum()->id)
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
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' sınıfına öğrenciler ekledi : $logArray";
            LogModel::create(['kategori_id' => 14, 'logText' => $logText]);

            $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' sınıfına öğrenciler ekledi : $logArray";
            kurumLogModel::create(['kategori_id' => 9, 'logText' => $kurumLogText, 'kurum_id' => get_current_kurum()->id]);

            return response()->json(['message' => "Öğrenciler sınıfa eklendi"]);
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
            if ($sinif->kurum_id != get_current_kurum()->id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $user = User::find($request->id);
            if (!$user)
                throw new Exception("Öğrenci bilgisi alınamadı");
            $exist->delete();
            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' adlı sınıftan '$user->ad $user->soyad' öğrenciyi çıkardı";
            LogModel::create(['kategori_id' => 19, 'logText' => $logText]);
            $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad' adlı sınıftan '$user->ad $user->soyad' öğrenciyi çıkardı";
            kurumLogModel::create(['kategori_id' => 14, 'logText' => $kurumLogText, 'kurum_id' => get_current_kurum()->id]);
            return response()->json(['message' => "Öğrenci '$user->ad $user->soyad' sınıftan kaldırıldı"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function dersProgramiCreate(Request $r)
    {
        try {
            $rules = array(
                'ders_id' => array('required'),
                'gun_id' => array('required', 'integer', 'between:1,7'),
                'baslangic' => array('required'),
                'bitis' => array('required'),
                'ogretmen_id' => array('required'),
                'sinif_id' => array('required', 'integer'),
            );
            $attributeNames = array(
                'ders_id' => "Ders",
                'gun_id' => "Gün",
                'baslangic' => "Başlangıç",
                'bitis' => "Bitiş",
                'ogretmen_id' => "Öğretmen",
                'sinif_id' => "Sınıf",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'integer' => ':attribute alanı numerik olmalıdır.',
                'between' => ':attribute alanı 1 ile 7 arasında olmalıdır',
            );
            $validator = Validator::make($r->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            $sinif = sinifModel::find($r->sinif_id);
            if (!$sinif)
                throw new Exception("Sınıf bilgisi alınamadı, Lütfen sayfayı yenileyin");
            if ($sinif->kurum_id != get_current_kurum()->id)
                throw new Exception("Sınıf bilgisi alınamadı, Lütfen sayfayı yenileyin");
            $ders = kurumDersModel::find($r->ders_id);
            if (!$ders)
                throw new Exception("Ders bilgisi alınamadı, Lütfen sayfayı yenileyin veya ders ekleyin");
            if ($ders->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders bilgisi alınamadı, Lütfen sayfayı yenileyin veya ders ekleyin");
            $ogretmen = User::find($r->ogretmen_id);
            if (!$ogretmen)
                throw new Exception("Öğretmen bilgisi alınamadı, Lütfen sayfayı yenileyin veya kurumunuza öğretmen ekleyin");
            if (!$ogretmen->hasRole('Öğretmen'))
                throw new Exception("Öğretmen bilgisi alınamadı, Lütfen sayfayı yenileyin veya kurumunuza öğretmen ekleyin");
            $ogretmen_kurum_exist = ogretmenKurumModel::where('ogretmen_id', $ogretmen->id)->where('kurum_id', get_current_kurum()->id)->first();
            if (!$ogretmen_kurum_exist)
                throw new Exception("Öğretmen bilgisi alınamadı, Lütfen sayfayı yenileyin");

            $doluSaatler = [];
            $gununProgrami = dersProgramiModel::where([
                'sinif_id' => $sinif->id,
                'gun_id' => $r->gun_id
            ])->get();
            foreach ($gununProgrami as $key) {
                array_push($doluSaatler, $key->baslangic . "-" . $key->bitis);
            }
            foreach ($doluSaatler as $key) {
                $baslangic = explode("-", $key)[0];
                $bitis = explode("-", $key)[1];
                $baslangicFormat = DateTime::createFromFormat('H:i', $baslangic);
                $bitisFormat = DateTime::createFromFormat('H:i', $bitis);
                $currentBaslangicFormat = DateTime::createFromFormat('H:i', $r->baslangic);
                $currentBitisFormat = DateTime::createFromFormat('H:i', $r->bitis);
                if ($currentBaslangicFormat >= $currentBitisFormat)
                    throw new Exception("Başlangıç saati bitiş saatinden büyük veya eşit olamaz");
                if ($currentBaslangicFormat >= $baslangicFormat && $currentBaslangicFormat < $bitisFormat)
                    throw new Exception("Başlangıç Saati Çakışıyor");
                if ($currentBitisFormat > $baslangicFormat && $currentBitisFormat <= $bitisFormat)
                    throw new Exception("Bitiş Saati Çakışıyor");
            }

            $dersprogrami = dersProgramiModel::create(array_merge($r->input(), [
                'kurum_id' => get_current_kurum()->id,
                'sinif_id' => $sinif->id
            ]));
            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad ($sinif->id)' sınıfında ders programı oluşturdu. Ders Programı ID: $dersprogrami->id";
            LogModel::create(['kategori_id' => 24, 'logText' => $logText]);
            $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), '$sinif->ad ($sinif->id)' sınıfında ders programı oluşturdu. Ders Programı ID: $dersprogrami->id";
            kurumLogModel::create(['kategori_id' => 19, 'logText' => $kurumLogText, 'kurum_id' => get_current_kurum()->id]);

            return response()->json(['message' => "Ders Programı Oluşturuldu"]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function yoklamaAl(Request $r)
    {
        try {
            $rules = array(
                'ders_programi_id' => array('required'),
                'ogrenci_id' => array('required'),
                'durum' => array('required'),
                'tarih' => array('required'),
                'first_day_of_week' => array('required'),
                'last_day_of_week' => array('required'),
            );
            $messages = array(
                'required' => 'Bazı bilgiler alınamadı lütfen sayfayı yenileyin',
            );
            $validator = Validator::make($r->all(), $rules, $messages);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            $dersProgrami = dersProgramiModel::find($r->ders_programi_id);
            if (!$dersProgrami)
                throw new Exception("Ders Programı Bulunamadı");
            if ($dersProgrami->kurum_id != get_current_kurum()->id)
                throw new Exception("Kurum ile ders programı uyuşmuyor");
            $ogrenci = User::find($r->ogrenci_id);
            if (!$ogrenci)
                throw new Exception("Öğrenci Bulunamadı");
            if (!ogrenciSinifModel::where('ogrenci_id', $ogrenci->id)->where('sinif_id', $dersProgrami->sinif_id)->first())
                throw new Exception("Öğrenci kurumunuza ait görünmüyor");
            $yoklamaExist = yoklamaModel::where([
                'ders_programi_id' => $dersProgrami->id,
                'ogrenci_id' => $ogrenci->id,
            ])->first();

            $tarihNumber = $r->tarih - 1;
            $tarihString = "+" . $tarihNumber . " day";
            $first_day_of_week = strtotime($r->first_day_of_week);
            $first_day_of_week = date("Y-m-d", $first_day_of_week);
            $tarih = new DateTime($first_day_of_week);
            $tarih->modify($tarihString);
            $tarih = $tarih->format("Y-m-d");

            if ($yoklamaExist) {
                if ($r->durum == -1)
                    $yoklamaExist->delete();
                else if ($r->durum == 0) {
                    $yoklamaExist->geldi = false;
                    $yoklamaExist->save();
                } else {
                    $yoklamaExist->geldi = true;
                    $yoklamaExist->save();
                }
            } else {
                if ($r->durum == 0) {
                    yoklamaModel::create([
                        'ders_programi_id' => $dersProgrami->id,
                        'ogrenci_id' => $ogrenci->id,
                        'geldi' => false,
                        'tarih' => "$tarih"
                    ]);
                } else if ($r->durum == 1) {
                    yoklamaModel::create([
                        'ders_programi_id' => $dersProgrami->id,
                        'ogrenci_id' => $ogrenci->id,
                        'geldi' => true,
                        'tarih' => "$tarih"
                    ]);
                }
            }
            return response()->json(['message' => "Yoklama Alındı"]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
