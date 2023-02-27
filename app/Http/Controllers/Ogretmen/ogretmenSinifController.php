<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\ogretmenDersModel;
use Illuminate\Http\Request;

class ogretmenSinifController extends Controller
{
    public function list()
    {
        $siniflar = [];
        $ogretmenDers = ogretmenDersModel::where('ogretmen_id', auth()->user()->id)->with('dersProgrami')->get();
        foreach ($ogretmenDers as $sinif) {
            if ($sinif->dersProgrami->count() > 0) {
                foreach ($sinif->dersProgrami as $dersProgrami) {
                    $current_array = [$dersProgrami->sinif->id, $dersProgrami->sinif->ad];
                    if (!in_array($current_array, $siniflar))
                        array_push($siniflar, $current_array);
                }
            }
        }
        return view('ogretmen.sinif.list')->with([
            'siniflar' => $siniflar
        ]);
    }
}
