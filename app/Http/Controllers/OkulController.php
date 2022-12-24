<?php

namespace App\Http\Controllers;

use App\Models\IlceModel;
use App\Models\OkulModel;
use Exception;
use Illuminate\Http\Request;

class OkulController extends Controller
{
    public function getOkulsFromIlce(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("İlçe bilgisi alınamadı");
            $ilce = IlceModel::find($request->id);
            if (!$ilce)
                throw new Exception("İlçe bilgisi alınamadı");
            $okullar = OkulModel::where('ilce_id', $ilce->id)->get();
            return response()->json(['data' => $okullar, 'error' => 0]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'error' => 1]);
        }
    }
}
