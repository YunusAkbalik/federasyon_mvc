<?php

namespace App\Http\Controllers;

use App\Models\IlModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function ogrenci_kayit()
    {
        $iller = IlModel::all();
        return view('ogrenci.register')->with([
            'iller' => $iller
        ]);
    }
    public function ogrenci_kayit_post(Request $request)
    {
        try {
            $rules = array(
                'tc_kimlik' => array('digits:11'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'il' => array('required'),
                'ilce' => array('required'),
                'okul' => array('required'),
                'sinif' => array('required'),
                'brans' => array('required'),
            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
                'dogum_tarihi' => "Doğum Tarihi",
                'il' => "İl",
                'ilce' => "İlçe",
                'okul' => "Okul",
                'sinif' => "Sınıf",
                'brans' => "Branş",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            User::create(array_merge($request->all(),array(
                'onayli' => false,
                'password' => bcrypt("0")
            )));
            return redirect()->route('home')->with("success","Kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return redirect()->route('ogrenci_kayit')->withErrors($exception->getMessage());
        }
    }
}
