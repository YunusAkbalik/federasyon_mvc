<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Jobs\KurumAddOkul;
use App\Models\IlceModel;
use App\Models\IlModel;
use App\Models\kurumOkulModel;
use App\Models\OgrenciOkulModel;
use App\Models\ogrenciSinifModel;
use App\Models\OkulModel;
use App\Models\sinifModel;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Nette\Utils\Json;

class kurumOkulController extends Controller
{
    /**
     * Kurum Okullarının Listesi
     * @return View
     */
    public function index()
    {
        $tumOkullar = OkulModel::orderBy('ad')->get();
        $kurum = get_current_kurum();
        $kurumOkullar = kurumOkulModel::where('kurum_id', $kurum->id)->with('KurumOzelsiniflar')->with('okul')->join('okul', 'kurum_okul.okul_id', '=', 'okul.id')->orderBy('okul.ad')->get();
        $iller = IlModel::all();
        return view('kurum.okullar.index')->with([
            'tumOkullar' => $tumOkullar,
            'kurumOkullar' => $kurumOkullar,
            'iller' => $iller,
        ]);
    }
    /**
     * Kuruma Okul ekle
     * @param Request $request
     * @return Json
     */
    public function add(Request $request)
    {
        try {
            KurumAddOkul::dispatch($request);
            return response()->json(['message' => "Okul kurumunuza başarıyla atandı"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    /**
     * Okul bilgisi ilse o okulun hangi il ilçeye bağlı olduğunun bilgisini döndürür
     * @param Request $request
     * @return JsonResponse
     */
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
    /**
     * Sınıfın Öğrencilerini getirir
     * @param Request $request
     * @return Json
     */
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
            if ($sinif->kurum_id != get_current_kurum()->id)
                throw new Exception("Sınıf bilgisi alınamadı");
            $siniftakiler = ogrenciSinifModel::where('sinif_id', $sinif->id)->get();
            $ogrenciler = OgrenciOkulModel::where('okul_id', $okul->id)->with('ogrenci')->orderBy('sube')->get();
            return response()->json(['data' => $ogrenciler, 'siniftakiler' => $siniftakiler]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
}
