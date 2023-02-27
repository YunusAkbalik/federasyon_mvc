<?php

namespace App\Http\Controllers;

use App\Models\kurumHizmetModel;
use App\Models\kurumModel;
use App\Models\kurumUserModel;
use App\Models\LogModel;
use App\Models\onePassesModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class kurumController extends Controller
{
    public function dashboard()
    {
        return view('kurum.dash');
    }
    public function list()
    {
        $kurumlar = kurumModel::all();
        return view('admin.kurumlar.list')->with(['kurumlar' => $kurumlar]);
    }
    public function create()
    {
        return view('admin.kurumlar.create');
    }
    public function create_post(Request $request)
    {
        try {
            $removeThis = ['(', ')', ' ', '-'];
            $gsm_no = str_replace($removeThis, "", $request->gsm_no_input);
            $telefon = str_replace($removeThis, "", $request->telefon_input);
            $yetkili_telefon = str_replace($removeThis, "", $request->yetkili_telefon_input);
            $wp_hatti = str_replace($removeThis, "", $request->wp_hatti_input);
            $hizmetler =  explode(",", $request->kurum_hizmetler);
            $rules = array(
                'unvan' => array('required'),
                'telefon_input' => array('required'),
                'adres' => array('required'),
                'vergi_dairesi' => array('required'),
                'vergi_no' => array('required', 'numeric'),
                'yetkili_kisi' => array('required'),
                'yetkili_telefon_input' => array('required'),
                'tc_kimlik' => array('digits:11', 'required'),
                'ad' => array('required'),
                'soyad' => array('required'),
            );
            $attributeNames = array(
                'tc_kimlik' => "T.C Kimlik",
                'ad' => "İsim",
                'soyad' => "Soyisim",
                'unvan' => "Ünvan",
                'telefon_input' => "Telefon",
                'adres' => "Adres",
                'vergi_dairesi' => "Vergi Dairesi",
                'vergi_no' => "Vergi No",
                'yetkili_kisi' => "Yetkili Kişi",
                'yetkili_telefon_input' => "Yetkili Telefon",
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
            if ($request->gsm_no_input) {
                $userExist = User::where('gsm_no', $gsm_no)->first();
                if ($userExist)
                    throw new Exception("Bu telefon numarasına ait bir kullanıcı var");
            }
            $kurum = kurumModel::create(array_merge([
                'telefon' => $telefon,
                'yetkili_telefon' => $yetkili_telefon,
                'wp_hatti' => $wp_hatti,
            ], $request->all()));
            $one_pass = rand(100000, 999999);
            $user = User::create(array_merge($request->all(), [
                'ozel_id' => ozel_id_uret(),
                'onayli' => true,
                'ret' => false,
                'ret_nedeni' => null,
                'password' => bcrypt($one_pass),
                'gsm_no' => $gsm_no
            ]));
            $user->assignRole('Kurum Yetkilisi');
            onePassesModel::create(['user_id' => $user->id, 'onePass' => $one_pass]);
            kurumUserModel::create(['kurum_id' => $kurum->id, 'user_id' => $user->id]);
            foreach ($hizmetler as $hizmet) {
                kurumHizmetModel::create([
                    'kurum_id' => $kurum->id,
                    'hizmet' => ucwords(trim($hizmet))
                ]);
            }
            $admin = auth()->user();
            $logText = "Admin $admin->ad $admin->soyad , Kurum oluşturdu ($kurum->unvan)";
            LogModel::create([
                'kategori_id' => 8,
                'logText' => $logText
            ]);
            return redirect()->back()->with('success', "Kurum oluşturuldu");
        } catch (Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }
    public function edit(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Kurum bulunamadı");
            $kurum = kurumModel::find($request->id);
            if (!$kurum)
                throw new Exception("Kurum bulunamadı");
            return view('admin.kurumlar.edit')->with(['kurum' => $kurum]);
        } catch (Exception $exception) {
            return redirect()->route('admin_list_kurum')->withErrors($exception->getMessage());
        }
    }
    public function get(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Kurum Bulunamadı");
            $kurum = kurumModel::where('id', $request->id)->with('hizmetler')->with('yetkili')->first();
            if (!$kurum)
                throw new Exception("Kurum Bulunamadı");
            return response()->json(['data' => $kurum]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 404);
        }
    }
}
