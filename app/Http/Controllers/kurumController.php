<?php

namespace App\Http\Controllers;

use App\Models\kurumModel;
use Illuminate\Http\Request;

class kurumController extends Controller
{
    public function dashboard()
    {
        dd("Kurum dash");
    }

    public function list()
    {
        $kurumlar = kurumModel::all();
        return view('admin.kurumlar.list')->with(['kurumlar' => $kurumlar]);
    }
}
