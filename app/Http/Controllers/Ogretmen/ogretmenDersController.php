<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\dersProgramiModel;
use App\Models\gunlerModel;
use DateTime;
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
}
