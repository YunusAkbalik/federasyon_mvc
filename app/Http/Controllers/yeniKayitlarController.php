<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class yeniKayitlarController extends Controller
{
    public function list()
    {
        $ogrenciler = User::role('Öğrenci')->where('onayli',false)->with('okul')->orderBy('created_at','ASC')->get();
        $veliler = User::role('Veli')->where('onayli',false)->orderBy('created_at','ASC')->get();
        return view('admin.yeni_kayitlar.list')->with([
            'ogrenciler' => $ogrenciler,
            'veliler' => $veliler,
        ]);
    }
}
