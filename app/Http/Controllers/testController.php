<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class testController extends Controller
{
    public function test()
    {
        dd(auth()->user()->getRoleNames()[0]);
    }
}
