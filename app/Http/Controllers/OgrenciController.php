<?php

namespace App\Http\Controllers;

use App\Models\OgrenciVeliModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class OgrenciController extends Controller
{
    public function getOgrenciFromTc(Request $request)
    {
        try {
            if (!$request->tc)
                throw new Exception("Öğrenci Bulunamadı");
            $ogrenci = User::where('tc_kimlik', $request->tc)->with('okul')->first();
            if (!$ogrenci)
                throw new Exception("Öğrenci Bulunamadı");
            if (!$ogrenci->hasRole('Öğrenci'))
                throw new Exception("Öğrenci Bulunamadı");
            $ogrenciVeliBaglantisi = OgrenciVeliModel::where('ogrenci_id', $ogrenci->id)->first();
            if ($ogrenciVeliBaglantisi)
                $ogrenciVeliBaglantisi = true;
            else
                $ogrenciVeliBaglantisi = false;

            return response()->json(['data' => $ogrenci, 'ogrenciVeliBaglanti' => $ogrenciVeliBaglantisi, 'error' => 0]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'error' => 1]);
        }
    }
}
