<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ogretmenController extends Controller
{
    public function dashboard()
    {
        dd("Öğretmen dash");
    }
    public function get_bekleyenler()
    {
        try {
            $bekleyenler = User::role("Öğretmen")->where('onayli', false)->where('ret', false)->get();
            return view('admin.ogretmen.bekleyen')->with(['data' => $bekleyenler]);
        } catch (Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function show_bekleyen(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Öğretmen Bulunamadı");
            $ogretmen = User::where('id', $request->id)->where('onayli', false)->where('ret', false)->with('ogretmen_cv')->first();
            if (!$ogretmen)
                throw new Exception("Öğretmen Bulunamadı");
            if (!$ogretmen->hasRole("Öğretmen"))
                throw new Exception("Öğretmen Bulunamadı");
            return response()->json(['data' => $ogretmen]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }

    public function onayla(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Öğretmen Bulunamadı");
            $ogretmen = User::find($request->id);
            if (!$ogretmen)
                throw new Exception("Öğretmen Bulunamadı");
            if (!$ogretmen->hasRole("Öğretmen"))
                throw new Exception("Öğretmen Bulunamadı");
            if ($ogretmen->onayli || $ogretmen->ret)
                throw new Exception("Öğretmen zaten onaylı veya reddedilmiş");
            $ogretmen->onayli = true;
            $ogretmen->save();
            return response()->json(['message' => "Öğretmen $ogretmen->ad $ogretmen->soyad, onaylandı"]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
    public function reddet(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Öğretmen Bulunamadı");
            $ogretmen = User::find($request->id);
            if (!$ogretmen)
                throw new Exception("Öğretmen Bulunamadı");
            if (!$ogretmen->hasRole("Öğretmen"))
                throw new Exception("Öğretmen Bulunamadı");
            if ($ogretmen->onayli || $ogretmen->ret)
                throw new Exception("Öğretmen zaten onaylı veya reddedilmiş");
            $ogretmen->ret = true;
            $ogretmen->ret_nedeni = $request->ret_nedeni;
            $ogretmen->save();
            return response()->json(['message' => "Öğretmen $ogretmen->ad $ogretmen->soyad, reddedildi"]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
}
