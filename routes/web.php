<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IlceController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OgrenciController;
use App\Http\Controllers\OkulController;
use App\Http\Controllers\onePassController;
use App\Http\Controllers\VeliController;
use App\Http\Controllers\yeniKayitlarController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Example Routes



Route::get('/', function () {
    return view('dashboard');
})->name('home');


Route::get('ogrenci-kayit', [AuthController::class, 'ogrenci_kayit'])->middleware('guest')->name('ogrenci_kayit');
Route::post('ogrenci-kayit', [AuthController::class, 'ogrenci_kayit_post'])->middleware('guest')->name('ogrenci_kayit_post');
Route::post('getIlceler', [IlceController::class, 'getIlceFromIl'])->name('getIlcelerFromIlID');
Route::post('getOkullar', [OkulController::class, 'getOkulsFromIlce'])->name('getOkullarFromIlceID');
Route::get('veli-kayit', [AuthController::class, 'veli_kayit'])->middleware('guest')->name('veli_kayit');
Route::post('veli-kayit', [AuthController::class, 'veli_kayit_post'])->middleware('guest')->name('veli_kayit_post');
Route::post('get-ogrenci-from-tc', [OgrenciController::class, 'getOgrenciFromTc'])->name('getOgrenciFromTc');
Route::post('get-veli-from-tc', [VeliController::class, 'getVeliFromTc'])->name('getVeliFromTc');

Route::prefix('admin')->group(function () {
    Route::get('loglar/{cid?}', [LogController::class, 'index'])->name('admin_loglar');
    Route::get('yeni-kayitlar', [yeniKayitlarController::class, 'list'])->name('admin_yeni_kayitlar');
    Route::get('tek-kullanimlik-sifreler', [onePassController::class, 'index'])->name('admin_tek_kullanimlik_sifreler');
    Route::post('tek-kullanimlik-sifre', [onePassController::class, 'getFromIDorGSM'])->name('admin_tek_kullanimlik_sifre_post');
    Route::prefix('kontrol')->group(function () {
        Route::get('/{ozel_id}', [yeniKayitlarController::class, 'kontrolEt'])->name('admin_kontrol');
        Route::post('onayla', [yeniKayitlarController::class, 'onayla'])->name('admin_kontrol_onay');
        Route::post('reddet', [yeniKayitlarController::class, 'reddet'])->name('admin_kontrol_reddet');
    });
    Route::prefix('hesapOlustur')->group(function () {
        Route::get('ogrenci', [AuthController::class, 'ogrenciHesapOlustur'])->name('admin_create_acc_ogrenci');
        Route::post('ogrenci', [AuthController::class, 'ogrenciHesapOlustur_post'])->name('admin_create_acc_ogrenci_post');
        Route::get('veli', [AuthController::class, 'veliHesapOlustur'])->name('admin_create_acc_veli');
        Route::post('veli', [AuthController::class, 'veliHesapOlustur_post'])->name('admin_create_acc_veli_post');
    });
});


Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');
