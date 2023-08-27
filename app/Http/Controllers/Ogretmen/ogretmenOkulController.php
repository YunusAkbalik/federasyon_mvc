<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\IlceModel;
use App\Models\IlModel;
use App\Models\Okul;
use Exception;
use Illuminate\Http\Request;

class ogretmenOkulController extends Controller
{
    public function getIlIlceFromOkul(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Okul bilgisi alınamadı");
            $okul = Okul::find($request->id);
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
