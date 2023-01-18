<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class adminController extends Controller
{
    public function dash()
    {
        return redirect()->route('admin_loglar');
    }
}
