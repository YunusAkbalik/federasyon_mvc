<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\kurumDersModel;
use App\Models\kurumLogModel;
use App\Models\kurumModel;
use App\Models\kurumOgretmenTalepModel;
use App\Models\kurumUserModel;
use App\Models\LogModel;
use App\Models\ogretmenDersModel;
use App\Models\ogretmenKurumModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OgretmenController extends Controller
{
    public function atamaBekleyenler()
    {
        try {
            $kurum_id = kurumUserModel::where('user_id', auth()->user()->id)->first();
            $kurum_id = $kurum_id->kurum_id;
            $talepler = [];
            $ogretmenler = User::Role('Öğretmen')->where('onayli', true)->with('kurum')->with('ogretmen_cv')->doesntHave('kurum')->get();
            foreach ($ogretmenler as $ogretmen) {
                $talep = kurumOgretmenTalepModel::where('kurum_id', $kurum_id)->where('ogretmen_id', $ogretmen->id)->first();
                if ($talep) {
                    array_push($talepler, $ogretmen->id);
                }
            }
            return view('kurum.ogretmen.atamabekleyen')->with([
                'ogretmenler' => $ogretmenler,
                'talepler' => $talepler,
            ]);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    public function show_bekleyen(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Öğretmen Bulunamadı");
            $ogretmen = User::where('id', $request->id)->where('onayli', true)->where('ret', false)->with('ogretmen_cv')->first();
            if (!$ogretmen)
                throw new Exception("Öğretmen Bulunamadı");
            if (!$ogretmen->hasRole("Öğretmen"))
                throw new Exception("Öğretmen Bulunamadı");
            $kurum = kurumUserModel::where('user_id', auth()->user()->id)->first();
            if (!$kurum)
                throw new Exception("Kurum Bulunamadı");
            $talep = kurumOgretmenTalepModel::where('kurum_id', $kurum->id)->where('ogretmen_id', $request->id)->first();
            if ($talep)
                $talep_gonderildi = true;
            else
                $talep_gonderildi = false;
            return response()->json(['data' => $ogretmen, 'talep' => $talep_gonderildi]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
    public function talep_et(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Öğretmen Bulunamadı");
            $ogretmen = User::find($request->id);
            if (!$ogretmen)
                throw new Exception("Öğretmen Bulunamadı");
            if ($ogretmen->onayli == false || $ogretmen->ret == true)
                throw new Exception("Öğretmen Bulunamadı");
            if (!$ogretmen->hasRole('Öğretmen'))
                throw new Exception("Öğretmen Bulunamadı");
            $kurum = kurumUserModel::where('user_id', auth()->user()->id)->first();
            if (!$kurum)
                throw new Exception("Kurum Bulunamadı");
            $talepExist = kurumOgretmenTalepModel::where('kurum_id', $kurum->id)->where('ogretmen_id', $request->id)->first();
            if ($talepExist)
                throw new Exception("Hali hazırda talep bekleniyor");
            kurumOgretmenTalepModel::create([
                'kurum_id' => $kurum->kurum_id,
                'ogretmen_id' => $request->id,
            ]);

            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), $ogretmen->ad $ogretmen->soyad ($ogretmen->ozel_id) öğretmene talep yolladı";
            LogModel::create([
                'kategori_id' => 11,
                'logText' => $logText
            ]);

            $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), $ogretmen->ad $ogretmen->soyad ($ogretmen->ozel_id) öğretmene talep yolladı";
            kurumLogModel::create([
                'kategori_id' => 7,
                'logText' => $kurumLogText,
                'kurum_id' => get_current_kurum()->id
            ]);




            return response()->json(['message' => "$ogretmen->ad $ogretmen->soyad öğretmene talep gönderildi."]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function derse_ata(Request $request)
    {
        try {
            if (!$request->ogretmenler)
                throw new Exception("Öğretmen bilgileri alınamadı");
            if (!$request->ders)
                throw new Exception("Ders bilgileri alınamadı");
            $ders = kurumDersModel::find($request->ders);
            if (!$ders)
                throw new Exception("Ders bilgileri alınamadı");
            if ($ders->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders bilgileri alınamadı");
            $ogretmenler = explode(",", $request->ogretmenler);
            foreach ($ogretmenler as $value) {
                $user = User::find($value);
                if (!$user)
                    throw new Exception("Öğretmen bilgileri alınamadı, sayfayı yenileyin");
                if (!$user->hasRole('Öğretmen'))
                    throw new Exception("$user->ad $user->soyad adlı kullanıcı öğretmen değil, sayfayı yenileyin");
                $kurumaAitOgretmen = ogretmenKurumModel::where('ogretmen_id', $user->id)->where('kurum_id', get_current_kurum()->id)->first();
                if (!$kurumaAitOgretmen)
                    throw new Exception("$user->ad $user->soyad öğretmen kurumunuzda çalışmıyor, sayfayı yenileyin");
                $derseAtanmis = ogretmenDersModel::where('ders_id', $request->ders)->where('ogretmen_id', $user->id)->first();
                if ($derseAtanmis)
                    throw new Exception("$user->ad $user->soyad zaten derse atanmış");
            }
            $addedList = array();
            foreach ($ogretmenler as $value) {
                ogretmenDersModel::create([
                    'ders_id' => $request->ders,
                    'ogretmen_id' => $value
                ]);
                $user = User::find($value);
                array_push($addedList, [
                    'ad_soyad' => $user->ad . " " . $user->soyad,
                    'id' => $user->id,
                    'ozel_id' => $user->ozel_id
                ]);
            }
            return response()->json(['message' => "Öğretmen(ler) başarıyla derse atandı", 'list' => $addedList]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function atamaKaldir(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Öğretmen bilgisi alınamadı");
            if (!$request->ders)
                throw new Exception("Ders bilgisi alınamadı");
            $user = User::find($request->id);
            $ders = kurumDersModel::find($request->ders);
            if (!$user)
                throw new Exception("Öğretmen bilgisi alınamadı");
            if (!$ders)
                throw new Exception("Ders bilgisi alınamadı");
            if (!$user->hasRole('Öğretmen'))
                throw new Exception("Kullanıcı öğretmen değil");
            if ($ders->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders bilgisi alınamadı");
            $atama = ogretmenDersModel::where('ogretmen_id', $user->id)->where('ders_id', $ders->id)->first();
            if (!$atama)
                throw new Exception("Öğretmen derse atanmamış, lütfen sayfayı yenileyin");
            $atama->delete();
            return response()->json(['message' => "Atama kaldırıldı"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
}
