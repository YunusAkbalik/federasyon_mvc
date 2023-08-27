<?php

namespace App\Http\Controllers;

use App\Models\IlceModel;
use App\Models\IlModel;
use App\Models\Okul;
use App\Validations\okul\OkulValidator;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OkulController extends Controller
{
    use OkulValidator;

    public function getOkulsFromIlce(Request $request)
    {
        try {
            if (! $request->id) {
                throw new Exception("İlçe bilgisi alınamadı");
            }
            $ilce = IlceModel::find($request->id);
            if (! $ilce) {
                throw new Exception("İlçe bilgisi alınamadı");
            }
            $okullar = Okul::where('ilce_id', $ilce->id)->get();

            return response()->json(['data' => $okullar, 'error' => 0]);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage(), 'error' => 1]);
        }
    }

    public function index(): View
    {
        $schools = Okul::with('ilce')->get();

        return view('admin.okul.index')->with([
            'schools' => $schools,
        ]);
    }

    public function create(): View
    {
        return view('admin.okul.store')->with([
            'iller' => IlModel::all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $this->validations();
            Okul::create([
                'ad'      => $request->get('okul_ad'),
                'ilce_id' => $request->get('ilce_id'),
            ]);

            return redirect()->route('okul.index')->with('success', 'Okul Oluşturuldu.');
        } catch (ValidationException $exception) {
            return redirect()->route('admin.okul.create')->withErrors($exception->errors());
        } catch (Exception $exception) {
            return redirect()->route('admin.okul.create')->withErrors($exception->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $okul = Okul::with('kurumlar')->find($id);
            if (! $okul) {
                throw new Exception('Okul bulunamadı', 404);
            }
            dd($okul);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], $exception->getCode() ?: 500);
        }
    }
}
