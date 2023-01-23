<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\kurumModel;
use App\Models\kurumOgretmenTalepModel;
use App\Models\LogModel;
use App\Models\ogretmenKurumModel;
use Exception;
use Illuminate\Http\Request;

class talepController extends Controller
{
    public function list()
    {
        $talepler = kurumOgretmenTalepModel::where('ogretmen_id', auth()->user()->id)->where('sonuc', null)->with('kurum')->with('kurum_owner')->get();
        return view('ogretmen.talepler')->with([
            'talepler' => $talepler
        ]);
    }
    public function sonuclandir(Request $request)
    {
        try {
            if (!$request->id || ($request->sonuc != 1 && $request->sonuc != 0))
                throw new Exception("Bir hata oluştu");
            $talep = kurumOgretmenTalepModel::find($request->id);
            if (!$talep)
                throw new Exception("Talep Bulunamadı");
            if ($talep->ogretmen_id != auth()->user()->id)
                throw new Exception("Bir hata oluştu");
            if ($talep->sonuc != null)
                throw new Exception("Bir hata oluştu");
            if ($request->sonuc == 1) {
                $talep->sonuc = true;
                $durum = "onayladı";
                ogretmenKurumModel::create([
                    'ogretmen_id' => auth()->user()->id,
                    'kurum_id' => $talep->kurum_id
                ]);
            } else {
                $talep->sonuc = false;
                $durum = "reddetti";
            }
            $talep->save();
            $ogretmen = auth()->user();
            $kurum = kurumModel::find($talep->kurum_id);
            $logText = "Öğretmen $ogretmen->ad $ogretmen->soyad ($ogretmen->ozel_id), Kurum '$kurum->unvan', talebini $durum.";
            LogModel::create([
                'kategori_id' => 12,
                'logText' => $logText,
            ]);
            return response()->json(['message' => "Talep sonuçlandı"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
}
