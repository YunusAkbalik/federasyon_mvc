<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ogretmenDersController extends Controller
{
    public function programList()
    {
        
        return view('ogretmen.dersprogrami.list');
    }
}
