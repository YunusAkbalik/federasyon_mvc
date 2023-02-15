<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\dersPlaniFilesModel;
use App\Models\dersPlaniModel;
use App\Models\kurumDersModel;
use App\Models\kurumLogModel;
use App\Models\LogModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class kurumDersPlaniController extends Controller
{
    public function index()
    {
        $dersPlanlari = dersPlaniModel::where('kurum_id', get_current_kurum()->id)->with('ders')->get();
        return view('kurum.dersPlani.index')->with([
            'dersPlanlari' => $dersPlanlari
        ]);
    }
    public function create()
    {
        $dersler = kurumDersModel::where('kurum_id', get_current_kurum()->id)->get();
        if ($dersler->count() <= 0)
            return redirect()->route('kurum_ders_index')->withErrors('Kurumunuza Ait Dersiniz Yok');
        return view('kurum.dersPlani.create')->with([
            'dersler' => $dersler
        ]);
    }
    public function insert(Request $r)
    {
        try {
            $rules = array(
                'ders_id' => array('required'),
                'siniflar' => array('required'),
                'konu' => array('required'),
                'dersin_islenisi' => array('required'),
            );
            $attributeNames = array(
                'ders_id' => "Ders",
                'siniflar' => "Sınıf",
                'konu' => "Konu",
                'dersin_islenisi' => "Dersin İşlenişi",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
            );
            $validator = Validator::make($r->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            $filesHere = $r->file('ders_dosyalari');
            $allowedfileExtension = ['png', 'jfif', 'jpeg', 'jpg', 'mp4', 'wav', 'pdf'];
            $siniflar = implode(",", $r->siniflar);
            $ders_plani = dersPlaniModel::create(array_merge([
                'kurum_id' => get_current_kurum()->id,
                'sinif' => $siniflar
            ], $r->input()));
            if ($filesHere != null) {
                foreach ($filesHere as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $fileName = Str::random() . "." . $extension;
                        $nameExist = true;
                        while ($nameExist) {
                            $checkFileName = dersPlaniFilesModel::where('path', $fileName)->first();
                            if (!$checkFileName)
                                $nameExist = false;
                            else
                                $fileName = Str::random() . "." . $extension;
                        }
                        $file->move('uploads/ders_plani_dosyalari', $fileName);
                        dersPlaniFilesModel::create([
                            'ders_plani_id' => $ders_plani->id,
                            'path' => $fileName,
                            'extension' => $extension
                        ]);
                    }
                }
            }

            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), ders planı ekledi. ID : $ders_plani->id";
            LogModel::create(['kategori_id' => 20, 'logText' => $logText]);

            $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), ders planı ekledi. ID : $ders_plani->id";
            kurumLogModel::create(['kategori_id' => 15, 'logText' => $kurumLogText, 'kurum_id' => get_current_kurum()->id]);
            return redirect()->route('kurum_dersPlani_index')->with('success', "Ders Planı Başarıyla Oluşturuldu");
        } catch (Exception $e) {
            return redirect()->route('kurum_dersPlani_create')->withErrors($e->getMessage());
        }
    }
    public function show(Request $r)
    {
        try {
            if (!$r->id)
                throw new Exception("Ders Planı Bulunamadı");
            $dersPlani = dersPlaniModel::where('id', $r->id)->with('ders')->first();
            if ($dersPlani->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders Planı Bulunamadı");
            $kurum = get_current_kurum();
            $siniflar = explode(",", $dersPlani->sinif);
            $dersPlaniFiles = dersPlaniFilesModel::where('ders_plani_id', $dersPlani->id)->get();
            return view('kurum.dersPlani.show')->with([
                'dersPlani' => $dersPlani,
                'kurum' => $kurum,
                'siniflar' => $siniflar,
                'dersPlaniFiles' => $dersPlaniFiles,
            ]);
        } catch (Exception $e) {
            return redirect()->route('kurum_dersPlani_index')->withErrors($e->getMessage());
        }
    }
    public function deleteFile(Request $r)
    {
        try {
            if (!$r->id)
                throw new Exception("Dosya bulunamadı, Lütfen sayfayı yenileyin");
            $fileDB = dersPlaniFilesModel::where('id', $r->id)->with('dersPlani')->first();
            if ($fileDB->dersPlani->kurum_id != get_current_kurum()->id)
                throw new Exception("Dosya bulunamadı, Lütfen sayfayı yenileyin");
            File::delete($fileDB->path);
            $dersPlaniID = $fileDB->dersPlani->id;
            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), '$dersPlaniID' idli ders planından dosya sildi. Silinen Dosya ID : $fileDB->id";
            LogModel::create(['kategori_id' => 22, 'logText' => $logText]);
            $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), '$dersPlaniID' idli ders planından dosya sildi. Silinen Dosya ID : $fileDB->id";
            kurumLogModel::create(['kategori_id' => 17, 'logText' => $kurumLogText, 'kurum_id' => get_current_kurum()->id]);
            $fileDB->delete();
            return response()->json(['message' => "Dosya kalıcı olarak silindi"]);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
    public function insertFile(Request $r)
    {
        try {
            if (!$r->dersPlaniID)
                throw new Exception("Ders Bilgisi Alınamadı");
            $dersPlani = dersPlaniModel::find($r->dersPlaniID);
            if ($dersPlani->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders Bilgisi Alınamadı");
            $filesHere = $r->file('dersplaniFiles');
            if ($filesHere == null)
                throw new Exception("Lütfen dosya yükleyin");
            $allowedfileExtension = ['png', 'jfif', 'jpeg', 'jpg', 'mp4', 'wav', 'pdf'];
            foreach ($filesHere as $file) {
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $fileName = Str::random() . "." . $extension;
                    $nameExist = true;
                    while ($nameExist) {
                        $checkFileName = dersPlaniFilesModel::where('path', $fileName)->first();
                        if (!$checkFileName)
                            $nameExist = false;
                        else
                            $fileName = Str::random() . "." . $extension;
                    }
                    $file->move('uploads/ders_plani_dosyalari', $fileName);
                    $dersPlaniNewFile = dersPlaniFilesModel::create([
                        'ders_plani_id' => $dersPlani->id,
                        'path' => $fileName,
                        'extension' => $extension
                    ]);
                    $logUser = auth()->user();
                    $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), '$dersPlani->id' idli ders planına dosya ekledi. Dosya ID : $dersPlaniNewFile->id";
                    LogModel::create(['kategori_id' => 21, 'logText' => $logText]);

                    $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), '$dersPlani->id' idli ders planına dosya ekledi. Dosya ID : $dersPlaniNewFile->id";
                    kurumLogModel::create(['kategori_id' => 16, 'logText' => $kurumLogText, 'kurum_id' => get_current_kurum()->id]);
                }
            }
            return redirect()->route('kurum_dersPlani_show', ['id' => $dersPlani->id])->with('success', "Uygun dosyalar yüklendi");
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
    public function edit(Request $r)
    {
        try {
            if (!$r->id)
                throw new Exception("Ders Planı Bulunamadı");
            $dersplani = dersPlaniModel::find($r->id);
            if (!$dersplani)
                throw new Exception("Ders Planı Bulunamadı");
            if ($dersplani->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders Planı Bulunamadı");
            $dersler = kurumDersModel::where('kurum_id', get_current_kurum()->id)->get();
            if ($dersler->count() <= 0)
                throw new Exception("Kurumunuza Ait Dersiniz Yok");
            $siniflar = explode(',', $dersplani->sinif);
            return view('kurum.dersPlani.edit')->with([
                'dersplani' => $dersplani,
                'dersler' => $dersler,
                'siniflar' => $siniflar,
            ]);
        } catch (Exception $e) {
            return redirect()->route('kurum_dersPlani_index')->withErrors($e->getMessage());
        }
    }
    public function update(Request $r)
    {
        try {
            $rules = array(
                'ders_id' => array('required'),
                'siniflar' => array('required'),
                'konu' => array('required'),
                'dersin_islenisi' => array('required'),
                'dersplaniID' => array('required'),
            );
            $attributeNames = array(
                'ders_id' => "Ders",
                'siniflar' => "Sınıf",
                'konu' => "Konu",
                'dersin_islenisi' => "Dersin İşlenişi",
                'dersplaniID' => "Ders Planı",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
            );
            $validator = Validator::make($r->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            $dersplani = dersPlaniModel::find($r->dersplaniID);
            if ($dersplani->kurum_id != get_current_kurum()->id)
                throw new Exception("Ders Planı bilgisi alınamadı");
            $filesHere = $r->file('ders_dosyalari');
            $allowedfileExtension = ['png', 'jfif', 'jpeg', 'jpg', 'mp4', 'wav', 'pdf'];
            $siniflar = implode(",", $r->siniflar);
            $dersplani->update(array_merge([
                'sinif' => $siniflar
            ], $r->input()));
            if ($filesHere != null) {
                foreach ($filesHere as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $check = in_array($extension, $allowedfileExtension);
                    if ($check) {
                        $fileName = Str::random() . "." . $extension;
                        $nameExist = true;
                        while ($nameExist) {
                            $checkFileName = dersPlaniFilesModel::where('path', $fileName)->first();
                            if (!$checkFileName)
                                $nameExist = false;
                            else
                                $fileName = Str::random() . "." . $extension;
                        }
                        $file->move('uploads/ders_plani_dosyalari', $fileName);
                        dersPlaniFilesModel::create([
                            'ders_plani_id' => $dersplani->id,
                            'path' => $fileName,
                            'extension' => $extension
                        ]);
                    }
                }
            }
            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), ders planını güncelledi. Ders planı id : $dersplani->id";
            LogModel::create(['kategori_id' => 23, 'logText' => $logText]);

            $kurumLogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), ders planını güncelledi. Ders planı id : $dersplani->id";
            kurumLogModel::create(['kategori_id' => 18, 'logText' => $kurumLogText, 'kurum_id' => get_current_kurum()->id]);
            return redirect()->route('kurum_dersPlani_show',['id' => $dersplani->id])->with('success', "Ders Planı Başarıyla Güncellendi");
        } catch (Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
    }
}
