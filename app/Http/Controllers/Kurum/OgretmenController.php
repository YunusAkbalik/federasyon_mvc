<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\ogretmenKurumModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class OgretmenController extends Controller
{
    public function atamaBekleyenler()
    {
        try {
            $ogretmenler = User::Role('Öğretmen')->where('onayli', true)->with('kurum')->with('ogretmen_cv')->doesntHave('kurum')->get();
            return view('kurum.ogretmen.atamabekleyen')->with(['ogretmenler' => $ogretmenler]);
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
}
