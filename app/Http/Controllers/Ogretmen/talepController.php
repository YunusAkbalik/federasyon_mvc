<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\kurumOgretmenTalepModel;
use Illuminate\Http\Request;

class talepController extends Controller
{
    public function list()
    {
        $talepler = kurumOgretmenTalepModel::where('ogretmen_id',auth()->user()->id)->with('kurum')->with('kurum_owner')->get();
        return view('ogretmen.talepler')->with([
            'talepler' => $talepler
        ]);
    }
}
