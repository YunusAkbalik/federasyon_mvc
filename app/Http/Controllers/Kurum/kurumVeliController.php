<?php

namespace App\Http\Controllers\Kurum;

use App\Http\Controllers\Controller;
use App\Models\kurumLogModel;
use App\Models\kurumModel;
use App\Models\LogModel;
use App\Models\OgrenciVeliModel;
use App\Models\onePassesModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class kurumVeliController extends Controller
{
    public function hesapOlustur()
    {
        return view('kurum.hesapOlustur.veli');
    }
    public function hesapOlustur_post(Request $request)
    {
        try {
            $rules = array(
                'tc_kimlik' => array('digits:11', 'required'),
                'ad' => array('required'),
                'soyad' => array('required'),
                'dogum_tarihi' => array('required'),
                'gsm_no' => array('required', 'digits:10'),
                'email' => array('required'),
            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "Ad",
                'soyad' => "Soyad",
                'dogum_tarihi' => "Doğum Tarihi",
                'gsm_no' => "Telefon Numarası",
                'email' => "E-posta Adresi",
            );
            $messages = array(
                'required' => ':attribute alanı zorunlu.',
                'digits' => ':attribute alanı :digits hane olmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            $userExist = User::where('tc_kimlik', $request->tc_kimlik)->first();
            if ($userExist)
                throw new Exception("Bu T.C Kimlik numarasına ait bir kullanıcı var.");
            if ($request->email) {
                $userExist = User::where('email', $request->email)->first();
                if ($userExist)
                    throw new Exception("Bu E-posta adresine ait bir kullanıcı var");
            }
            if ($request->gsm_no) {
                $userExist = User::where('gsm_no', $request->gsm_no)->first();
                if ($userExist)
                    throw new Exception("Bu telefon numarasına ait bir kullanıcı var");
            }
            $one_pass = rand(100000, 999999);
            $newUser = User::create(array_merge($request->all(), [
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($one_pass),
                'ozel_id' => ozel_id_uret()
            ]));
            $newUser->assignRole('Veli');
            if ($request->ogrenci_tc) {
                $ogrenci = User::where('tc_kimlik', $request->ogrenci_tc)->first();
                if ($ogrenci) {
                    if ($ogrenci->hasRole('Öğrenci')) {
                        if (!(OgrenciVeliModel::where('ogrenci_id', $ogrenci->id)->first())) {
                            OgrenciVeliModel::create([
                                'ogrenci_id' => $ogrenci->id,
                                'veli_id' => $newUser->id,
                            ]);
                        }
                    }
                }
            }

            $logUser = auth()->user();
            $logText = "Kurum Yetkilisi $logUser->ad $logUser->soyad ($logUser->ozel_id), sisteme veli ekledi ($newUser->ad $newUser->soyad ($newUser->ozel_id))";
            LogModel::create(['kategori_id' => 7, 'logText' => $logText]);

            $kurumlogText = "$logUser->ad $logUser->soyad ($logUser->ozel_id), sisteme veli ekledi ($newUser->ad $newUser->soyad ($newUser->ozel_id))";
            kurumLogModel::create(['kategori_id' => 4, 'logText' => $kurumlogText , 'kurum_id' => get_current_kurum()->id]);

            onePassesModel::create([
                'user_id' => $newUser->id,
                'onePass' => $one_pass
            ]);
            return redirect()->route('kurum_hesapOlustur_veli')->with("success", "Veli kayıt işlemi başarılı");
        } catch (Exception $exception) {
            return back()->withErrors($exception->getMessage());
        }
    }
}
