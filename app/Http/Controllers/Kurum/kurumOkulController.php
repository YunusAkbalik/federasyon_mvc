<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\IlceModel;
use App\Models\IlModel;
use App\Models\kurumModel;
use App\Models\kurumOkulModel;
use App\Models\kurumUserModel;
use App\Models\OkulModel;
use Exception;
use Illuminate\Http\Request;

class kurumOkulController extends Controller
{
    public function index()
    {
        $tumOkullar = OkulModel::orderBy('ad')->get();
        $kurumiliski = kurumUserModel::where('user_id', auth()->user()->id)->first();
        $kurum = kurumModel::find($kurumiliski->kurum_id);
        $kurumOkullar = kurumOkulModel::where('kurum_id', $kurum->id)->with('siniflar')->with('okul')->join('okul', 'kurum_okul.okul_id', '=', 'okul.id')->orderBy('okul.ad')->get();
        
        $iller = IlModel::all();
        return view('kurum.okullar.index')->with([
            'tumOkullar' => $tumOkullar,
            'kurumOkullar' => $kurumOkullar,
            'iller' => $iller,
        ]);
    }

    public function add(Request $request)
    {
        try {
            if (!$request->okul_id)
                throw new Exception("Okul Bulunamadı");
            $okul = OkulModel::find($request->okul_id);
            if (!$okul)
                throw new Exception("Okul Bulunamadı");
            $kurumiliski = kurumUserModel::where('user_id', auth()->user()->id)->first();
            if (!$kurumiliski)
                throw new Exception("Kurum Bulunamadı");
            $kurum = kurumModel::find($kurumiliski->kurum_id);
            if (!$kurum)
                throw new Exception("Kurum Bulunamadı");
            $kurumOkul = kurumOkulModel::where('okul_id', $okul->id)->where('kurum_id', $kurum->id)->first();
            if ($kurumOkul)
                throw new Exception("Bu okul eklenmiş durumda");
            kurumOkulModel::create([
                'okul_id' => $okul->id,
                'kurum_id' => $kurum->id,
            ]);
            return response()->json(['message' => "Okul kurumunuza başarıyla atandı"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }

    public function getIlIlceFromOkul(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Okul bilgisi alınamadı");
            $okul = OkulModel::find($request->id);
            if (!$okul)
                throw new Exception("Okul bilgisi alınamadı");
            $ilce = IlceModel::find($okul->ilce_id);
            $il = IlModel::find($ilce->il_id);
            $data = [
                "okul" => $okul->id,
                "ilce" => $ilce->id,
                "il" => $il->id,
            ];
            return response()->json(['data' => $data]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
}
