<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\dersPlaniFilesModel;
use App\Models\dersPlaniModel;
use App\Models\kurumDersModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class kurumDersPlaniController extends Controller
{
    public function index()
    {
        return view('kurum.dersPlani.index');
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
                        'path' => $fileName
                    ]);
                }
            }
            return redirect()->route('kurum_dersPlani_index')->with('success', "Ders Planı Başarıyla Oluşturuldu");
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->route('kurum_dersPlani_create')->withErrors($e->getMessage());
        }
    }
}
