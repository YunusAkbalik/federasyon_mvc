<?php

namespace App\Http\Controllers;

use App\Models\OgrenciOkulModel;
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
        $veliler = User::role("Veli")->get();
        return view('admin.kayitlar.veli')->with([
            'veliler' => $veliler
        ]);
    }
    public function get(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Veli bulunamadı");
            $user = User::find($request->id);
            if (!$user)
                throw new Exception("Veli bulunamadı");
            if (!$user->hasRole('Veli'))
                throw new Exception("Veli bulunamadı");
            $ogrenciVeli = OgrenciVeliModel::where('veli_id', $user->id)->first();
            if ($ogrenciVeli) {
                $ogrencisi = User::find($ogrenciVeli->ogrenci_id);
                $okul = OgrenciOkulModel::where("ogrenci_id", $ogrencisi->id)->with('okulDetails')->first();
            } else {
                $ogrencisi = null;
                $okul = null;
            }
            return response()->json(array(
                'veli' => $user,
                'ogrenci' => $ogrencisi,
                'okul' => $okul,
                'error' => 0
            ));
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'error' => 1]);
        }
    }
    public function dashboard()
    {
        dd("Veli Dash");
    }
}
