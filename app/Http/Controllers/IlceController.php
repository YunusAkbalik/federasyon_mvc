<?php

namespace App\Http\Controllers;

use App\Models\IlceModel;
use App\Models\IlModel;
use Exception;
use Illuminate\Http\Request;

class IlceController extends Controller
{
    public function getIlceFromIl(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("İl Algınlanmadı");
            $il = IlModel::find($request->id);
            if (!$il)
                throw new Exception("İl Algınlanmadı");
            $ilceler = IlceModel::where('il_id', $il->id)->get();
            return response()->json(['data' => $ilceler, 'error' => 0]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'error' => 1]);
        }
    }
}
