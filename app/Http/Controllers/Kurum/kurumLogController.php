<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\kurumLogKategoriModel;
use App\Models\kurumLogModel;
use Illuminate\Http\Request;

class kurumLogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->cid != 0)
            $logs = kurumLogModel::where('kategori_id', $request->cid)->where('kurum_id', get_current_kurum()->id)->orderBy('created_at', 'DESC')->paginate(10);
        else
            $logs = kurumLogModel::orderBy('created_at', 'DESC')->where('kurum_id',get_current_kurum()->id)->paginate(10);
        $logCategories = kurumLogKategoriModel::all();
        return view('kurum.loglar.index')->with(['logs' => $logs, 'logCategories' => $logCategories, 'cid' => $request->cid]);
    }
}
