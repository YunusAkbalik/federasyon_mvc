<?php

namespace App\Http\Controllers;

use App\Models\LogKategoriModel;
use App\Models\LogModel;
use Exception;
use Illuminate\Http\Request;

class LogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->cid != 0)
            $logs = LogModel::where('kategori_id', $request->cid)->orderBy('created_at' , 'DESC')->paginate(10);
        else
            $logs = LogModel::orderBy('created_at' , 'DESC')->paginate(10);
        $logCategories = LogKategoriModel::orderBy('ad')->get();
        return view('admin.loglar.index')->with(['logs' => $logs , 'logCategories' => $logCategories , 'cid' => $request->cid]);
    }
}
