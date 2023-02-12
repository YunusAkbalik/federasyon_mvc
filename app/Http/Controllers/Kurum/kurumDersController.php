<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\kurumDersModel;
use Exception;
use Illuminate\Http\Request;

class kurumDersController extends Controller
{
    public function index()
    {
        $dersler = kurumDersModel::where('kurum_id', get_current_kurum()->id)->get();
        return view('kurum.dersler.index')->with([
            'dersler' => $dersler
        ]);
    }
    public function add(Request $request)
    {
        try {
            if (!$request->yeniDersAdi)
                throw new Exception("Ders adı girin");
            $ders = $request->yeniDersAdi;
            $dersExist = kurumDersModel::where([
                'kurum_id' => get_current_kurum()->id,
                'ad' => $ders
            ])->first();
            if ($dersExist)
                throw new Exception("Bu ders mevcut");
            kurumDersModel::create([
                'kurum_id' => get_current_kurum()->id,
                'ad' => $ders
            ]);
            return response()->json(['message' => "Ders Eklendi"]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function show(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Ders Bulunamadı");
            $ders = kurumDersModel::find($request->id);
            if (!$ders)
                throw new Exception("Ders Bulunamadı");
            if ($ders->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders Bulunamadı");
            return view('kurum.dersler.show')->with([
                'ders' => $ders
            ]);
        } catch (Exception $ex) {
            return redirect()->route('kurum_ders_index')->withErrors($ex->getMessage());
        }
    }
}
