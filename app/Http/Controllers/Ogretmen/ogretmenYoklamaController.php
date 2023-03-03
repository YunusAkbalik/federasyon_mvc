<?php

namespace App\Http\Controllers\Ogretmen;

use App\Http\Controllers\Controller;
use App\Models\dersProgramiModel;
use App\Models\gunlerModel;
use App\Models\kurumLogModel;
use App\Models\LogModel;
use App\Models\ogrenciSinifModel;
use App\Models\yoklamaModel;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class ogretmenYoklamaController extends Controller
{
    public function dersList()
    {
        $dersProgrami = dersProgramiModel::where('ogretmen_id', auth()->user()->id)
            ->where('gun_id', date('w'))
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
        return view('ogretmen.yoklama.list')
            ->with([
                'dersProgrami' => $dersProgrami,
                'gunler' => $gunler,
                'saatler' => $saatler,
                'suankiDers' => $suankiDers,
            ]);
    }
    public function show(Request $r)
    {
        try {
            if (!$r->id)
                throw new Exception("Ders Bilgisi Alınamadı");
            $dersprogramiSelect = dersProgramiModel::find($r->id);
            if (!$dersprogramiSelect)
                throw new Exception("Ders Bilgisi Alınamadı");
            if ($dersprogramiSelect->gun_id != date('w'))
                throw new Exception("Yoklama alma süresi gecikti");
            $dersprogrami = dersProgramiModel::where('ders_id', $dersprogramiSelect->ders_id)
                ->where('gun_id', $dersprogramiSelect->gun_id)
                ->where('sinif_id', $dersprogramiSelect->sinif_id)
                ->with('ders')
                ->with('gun')
                ->with('sinif')
                ->with('yoklama')
                ->orderBy('baslangic')
                ->get();

            return view('ogretmen.yoklama.show')->with([
                'dersprogrami' => $dersprogrami
            ]);
        } catch (Exception $e) {
            return redirect()->route('ogretmen_yoklama_list')->withErrors($e->getMessage());
        }
    }
    public function yoklamaAl(Request $r)
    {
        try {
            $alindi = false;
            foreach ($r->input() as $key => $value) {
                if ($key != "_token") {
                    $input_array = explode('_', $key);
                    $ogrenci_id = $input_array[1];
                    $ders_programi_id = $input_array[2];
                    $dersprogramidb = dersProgramiModel::find($ders_programi_id);
                    if (!$dersprogramidb)
                        throw new Exception("Ders Programı Bulunamadı");
                    $ogrenciExist = ogrenciSinifModel::where('ogrenci_id', $ogrenci_id)->with('sinif')->first();
                    if (!$ogrenciExist)
                        throw new Exception("Öğrenci Bulunamadı");
                    if ($ogrenciExist->sinif->kurum_id != get_ogretmen_current_kurum()->id)
                        throw new Exception("Öğrenci Bulunamadı");
                    if ($value == 1)
                        $geldi = true;
                    else
                        $geldi = false;
                    $yoklamaExist = yoklamaModel::where([
                        'ders_programi_id' => $ders_programi_id,
                        'ogrenci_id' => $ogrenci_id,
                        'tarih' => date('Y-m-d'),
                    ])
                        ->first();
                    if ($yoklamaExist)
                        $yoklamaExist->delete();
                    yoklamaModel::create([
                        'ders_programi_id' => $ders_programi_id,
                        'ogrenci_id' => $ogrenci_id,
                        'geldi' => $geldi,
                        'tarih' => date('Y-m-d')
                    ]);
                    $alindi = true;
                }
            }
            if (!$alindi)
                throw new Exception("Yoklama Alınmadı");

            $gun = gunlerModel::where('id', date('w'))->first()->ad;
            $dersprogrami_db_for_log = dersProgramiModel::where('id', $ders_programi_id)
                ->with('ders')
                ->with('sinif')
                ->first();
            $ders_ad = $dersprogrami_db_for_log->ders->ad;
            $sinif_ad = $dersprogrami_db_for_log->sinif->ad;
            $logUser = auth()->user();
            $logText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), $gun günü için '$sinif_ad' sınıfında '$ders_ad' ders yoklamasını aldı";
            LogModel::create(['kategori_id' => 25, 'logText' => $logText]);
            $kurumLogText = "Öğretmen $logUser->ad $logUser->soyad ($logUser->ozel_id), $gun günü için '$sinif_ad' sınıfında '$ders_ad' ders yoklamasını aldı";
            kurumLogModel::create(['kategori_id' => 20, 'logText' => $kurumLogText, 'kurum_id' => get_ogretmen_current_kurum()->id]);
            return redirect()->route('ogretmen_yoklama_show', ['id' => $ders_programi_id])->with('success', 'Yoklama Kaydedildi');
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
