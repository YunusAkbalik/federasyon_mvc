<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function RouteMe()
    {
        try {
            $user = auth()->user();
            if ($user->hasRole('Admin'))
                return redirect()->route('admin_dash');
            if ($user->hasRole('Veli'))
                return redirect()->route('veli_dash');
            if ($user->hasRole('Öğrenci'))
                return redirect()->route('ogrenci_dash');
               
        } catch (Exception $th) {
            dd($th->getMessage());
        }
    }
}
