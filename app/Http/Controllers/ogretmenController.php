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
}
