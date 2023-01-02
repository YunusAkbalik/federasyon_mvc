<?php

namespace App\Http\Controllers;

use App\Models\onePassesModel;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

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
}
