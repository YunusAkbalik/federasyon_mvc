<?php

namespace App\Http\Controllers;

use App\Models\onePassesModel;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class onePassController extends Controller
{
    public function index()
    {
        return view('admin.tek_kullanimlik_sifreler.search');
    }
    public function getFromIDorGSM(Request $request)
    {
        try {
            if (!$request->search)
                throw new Exception("Kullanıcı Bulunamadı");
            $user = User::where(function ($query) use ($request) {
                $query->where('ozel_id', $request->search)
                    ->orWhere('gsm_no', $request->search);
            })->first();
            if (!$user)
                throw new Exception("Kullanıcı Bulunamadı");
            $onePassExist = onePassesModel::where('user_id', $user->id)->first();
            if (!$onePassExist)
                throw new Exception("Kullanıcının tek kullanımlık şifresi yok!");
            return response()->json(['user' => $user, 'onePass' => $onePassExist->onePass, 'error' => 0]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'error' => 1]);
        }
    }
    public function changePass()
    {
        if (!Auth::check())
            return redirect()->route('routeThisGuy');
        $onePassExist = onePassesModel::where('user_id', auth()->user()->id)->first();
        if (!$onePassExist)
            return redirect()->route('routeThisGuy');
        return view('auth.onePass.change');
    }
    public function changePost(Request $request)
    {
        try {
            $rules = array(
                'password' => array('required', 'numeric', 'digits:8'),
            );
            $attributeNames = array(
                'password' => "Yeni Parola",
            );
            $messages = array(
                'required' => ':attribute girin.',
                'digits' => ':attribute 8 rakamdan oluşmalıdır.',
            );
            $validator = Validator::make($request->all(), $rules, $messages, $attributeNames);
            if ($validator->fails())
                throw new Exception($validator->errors()->first());
            User::where('id', auth()->user()->id)->update([
                'password' => Hash::make($request->password)
            ]);
            onePassesModel::where('user_id', auth()->user()->id)->delete();
            return redirect()->route('routeThisGuy');
        } catch (Exception $ex) {
            return redirect()->back()->withErrors($ex->getMessage());
        }
    }
    public function getUser(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Kullanıcı Bulunamadı");
            $user = User::where(function ($query) use ($request) {
                $query->where('ozel_id', '=', $request->id)
                    ->orWhere('gsm_no', '=', $request->id);
            })->first();
            if (!$user)
                throw new Exception("Kullanıcı Bulunamadı");
            $onePassExist = onePassesModel::where('user_id', $user->id)->first();
            $role = $user->getRoleNames()[0];
            return response()->json(['user' => $user, 'onePass' => $onePassExist, 'role' => $role]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
    public function generateOnePass(Request $request)
    {
        try {
            if (!$request->id)
                throw new Exception("Kullanıcı Bulunamadı");
            $user = User::find($request->id);
            if (!$user)
                throw new Exception("Kullanıcı Bulunamadı");
            $onePassExist = onePassesModel::where('user_id', $user->id)->first();
            if($onePassExist)
                $onePassExist->delete();
            $one_pass = rand(100000, 999999);
            $user->update([
                'password' => Hash::make($one_pass)
            ]);
            onePassesModel::create([
                'user_id' => $user->id,
                'onePass' => $one_pass
            ]);
            return response()->json(['message' => "Parola Sıfırlandı" , 'onePass' => $one_pass]);
        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 404);
        }
    }
}
