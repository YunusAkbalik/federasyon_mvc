<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\ogretmenDersModel;
use Illuminate\Http\Request;

class ogretmenSinifController extends Controller
{
    public function list()
    {
        $ogretmenDers = ogretmenDersModel::where('ogretmen_id',auth()->user()->id)->with('dersProgrami')->get();
        return view('ogretmen.sinif.list')->with([
            'ogretmenDers' => $ogretmenDers
        ]);
    }
}
