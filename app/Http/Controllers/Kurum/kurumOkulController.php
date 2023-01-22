<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
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
        $kurumOkullar = kurumOkulModel::where('kurum_id', $kurum->id)->with('okul')->join('okul', 'kurum_okul.okul_id', '=', 'okul.id')->orderBy('okul.ad')->get();
        return view('kurum.okullar.index')->with([
            'tumOkullar' => $tumOkullar,
            'kurumOkullar' => $kurumOkullar,
        ]);
    }

    public function add(Request $request)
    {
        try {
            if (!$request->ad)
                throw new Exception("Okul Bulunamadı");
            $okul = OkulModel::where('ad', $request->ad)->first();
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
}
