<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ogretmenSinifController extends Controller
{
    public function list()
    {
        
        return view('ogretmen.sinif.list');
    }
}
