<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\dersPlaniFilesModel;
use App\Models\dersPlaniModel;
use App\Models\dersProgramiModel;
use App\Models\gunlerModel;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class ogretmenDersController extends Controller
{
    public function programList()
    {
        $dersProgrami = dersProgramiModel::where('ogretmen_id', auth()->user()->id)
            ->with('sinif')
            ->orderBy('baslangic')
            ->get();
        $gunler = gunlerModel::all();
        $saatler = [];
        $suankiDers = null;
        foreach ($dersProgrami as $key) {
            $saat = $key->baslangic . "-" . $key->bitis;
            if (!in_array($saat, $saatler))
                array_push($saatler, $saat);
            $baslangic = DateTime::createFromFormat('H:i', $key->baslangic);
            $bitis = DateTime::createFromFormat('H:i', $key->bitis);
            $suan = DateTime::createFromFormat('H:i', date('H:i'));
            if ($suan >= $baslangic && $suan <= $bitis && $key->gun_id == date('w')) {
                $suankiDers = $key;
            }
        }
        return view('ogretmen.dersprogrami.list')
            ->with([
                'dersProgrami' => $dersProgrami,
                'gunler' => $gunler,
                'saatler' => $saatler,
                'suankiDers' => $suankiDers,
            ]);
    }
    public function planList()
    {
        $dersPlanlari = dersPlaniModel::where('kurum_id', get_ogretmen_current_kurum()->id)
            ->whereHas('ogretmen',function($query){
                return $query->where('ogretmen_id',auth()->user()->id);
            })
            ->with('ders')
            ->get();
        return view('ogretmen.dersplani.index')->with([
            'dersPlanlari' => $dersPlanlari
        ]);
    }
    public function planShow(Request $r)
    {
        try {
            if (!$r->id)
                throw new Exception("Ders Planı Bulunamadı");
            $dersPlani = dersPlaniModel::where('id', $r->id)->with('ders')->first();
            if (!$dersPlani)
                throw new Exception("Ders Planı Bulunamadı");
            if ($dersPlani->kurum_id != get_ogretmen_current_kurum()->id)
                throw new Exception("Ders Planı Bulunamadı");
            $kurum = get_ogretmen_current_kurum();
            $siniflar = explode(",", $dersPlani->sinif);
            $dersPlaniFiles = dersPlaniFilesModel::where('ders_plani_id', $dersPlani->id)->get();
            return view('ogretmen.dersplani.show')->with([
                'dersPlani' => $dersPlani,
                'kurum' => $kurum,
                'siniflar' => $siniflar,
                'dersPlaniFiles' => $dersPlaniFiles,
            ]);
        } catch (Exception $e) {
            return redirect()->route('ogretmen_dersplani_list')->withErrors($e->getMessage());
        }
    }
}
