<?php

namespace App\Http\Controllers;

use App\Models\OgrenciVeliModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class VeliController extends Controller
{
    public function getVeliFromTc(Request $request)
    {
        try {
            if (!$request->tc)
                throw new Exception("Veli Bulunamadı");
            $veli = User::where('tc_kimlik', $request->tc)->first();
            if (!$veli)
                throw new Exception("Veli Bulunamadı");
            if (!$veli->hasRole('Veli'))
                throw new Exception("Veli Bulunamadı");
            $veliOgrenciBaglantisi = OgrenciVeliModel::where('veli_id', $veli->id)->first();
            if ($veliOgrenciBaglantisi)
                $veliOgrenciBaglantisi = true;
            else
                $veliOgrenciBaglantisi = false;
            return response()->json(['data' => $veli, 'veliOgrenciBaglanti' => $veliOgrenciBaglantisi, 'error' => 0]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'error' => 1]);
        }
    }
    public function list()
    {
        return view('admin.kayitlar.veli');
    }
}
