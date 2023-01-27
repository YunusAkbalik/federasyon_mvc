<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\kurumLogModel;
use App\Models\kurumModel;
use App\Models\kurumOgretmenTalepModel;
use App\Models\kurumUserModel;
use App\Models\LogModel;
use App\Models\ogretmenKurumModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

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
}
