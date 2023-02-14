<?php

use App\Http\Controllers\Kurum\OgretmenController as KurumOgretmenController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\IlceController;
use App\Http\Controllers\Kurum\kurumDersController;
use App\Http\Controllers\Kurum\kurumDersPlaniController;
use App\Http\Controllers\Kurum\kurumLogController;
use App\Http\Controllers\Kurum\kurumOgrenciController;
use App\Http\Controllers\Kurum\kurumOkulController;
use App\Http\Controllers\Kurum\kurumSinifController;
use App\Http\Controllers\Kurum\kurumVeliController;
use App\Http\Controllers\kurumController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\OgrenciController;
use App\Http\Controllers\Ogretmen\talepController;
use App\Http\Controllers\ogretmenController;
use App\Http\Controllers\OkulController;
use App\Http\Controllers\onePassController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\testController;
use App\Http\Controllers\VeliController;
use App\Http\Controllers\yeniKayitlarController;
use App\Models\kurumModel;
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





Route::get('/', [AuthController::class, 'login'])->middleware('guest')->name('giris_yap');
Route::post('login', [AuthController::class, 'loginPost'])->middleware('guest')->name('giris_yap_post');
Route::get('route', [RouteController::class, 'RouteMe'])->middleware('auth')->name('routeThisGuy');
Route::get('cikis', [AuthController::class, 'logout'])->middleware('auth')->name('cikis_yap');
Route::get('test', [testController::class, 'test']);



Route::get('ogrenci-kayit', [AuthController::class, 'ogrenci_kayit'])->middleware('guest')->name('ogrenci_kayit');
Route::post('ogrenci-kayit', [AuthController::class, 'ogrenci_kayit_post'])->middleware('guest')->name('ogrenci_kayit_post');
Route::get('ogretmen-kayit', [AuthController::class, 'ogretmen_kayit'])->middleware('guest')->name('ogretmen_kayit');
Route::post('ogretmen-kayit', [AuthController::class, 'ogretmen_kayit_post'])->middleware('guest')->name('ogretmen_kayit_post');
Route::post('getIlceler', [IlceController::class, 'getIlceFromIl'])->name('getIlcelerFromIlID');
Route::post('getOkullar', [OkulController::class, 'getOkulsFromIlce'])->name('getOkullarFromIlceID');
Route::get('veli-kayit', [AuthController::class, 'veli_kayit'])->middleware('guest')->name('veli_kayit');
Route::post('veli-kayit', [AuthController::class, 'veli_kayit_post'])->middleware('guest')->name('veli_kayit_post');
Route::post('get-ogrenci-from-tc', [OgrenciController::class, 'getOgrenciFromTc'])->name('getOgrenciFromTc');
Route::post('get-veli-from-tc', [VeliController::class, 'getVeliFromTc'])->name('getVeliFromTc');


Route::middleware('onePass')->group(function () {
    Route::prefix('admin')->middleware('role:Admin')->group(function () {
        Route::get('/', [adminController::class, 'dash'])->name('admin_dash');
        Route::get('loglar/{cid?}', [LogController::class, 'index'])->name('admin_loglar');
        Route::get('yeni-kayitlar', [yeniKayitlarController::class, 'list'])->name('admin_yeni_kayitlar');
        Route::get('tek-kullanimlik-sifreler', [onePassController::class, 'index'])->name('admin_tek_kullanimlik_sifreler');
        Route::post('tek-kullanimlik-sifre', [onePassController::class, 'getFromIDorGSM'])->name('admin_tek_kullanimlik_sifre_post');
        Route::post('tek-kullanimlik-sifre-user-get', [onePassController::class, 'getUser'])->name('admin_tek_kullanimlik_sifre_get_user_post');
        Route::post('tek-kullanimlik-sifre-user-generate', [onePassController::class, 'generateOnePass'])->name('admin_tek_kullanimlik_sifre_generate_post');
        Route::prefix('kontrol')->group(function () {
            Route::get('/{ozel_id}', [yeniKayitlarController::class, 'kontrolEt'])->name('admin_kontrol');
            Route::post('onayla', [yeniKayitlarController::class, 'onayla'])->name('admin_kontrol_onay');
            Route::post('reddet', [yeniKayitlarController::class, 'reddet'])->name('admin_kontrol_reddet');
        });
        Route::prefix('hesap-olustur')->group(function () {
            Route::get('ogrenci', [AuthController::class, 'ogrenciHesapOlustur'])->name('admin_create_acc_ogrenci');
            Route::post('ogrenci', [AuthController::class, 'ogrenciHesapOlustur_post'])->name('admin_create_acc_ogrenci_post');
            Route::get('veli', [AuthController::class, 'veliHesapOlustur'])->name('admin_create_acc_veli');
            Route::post('veli', [AuthController::class, 'veliHesapOlustur_post'])->name('admin_create_acc_veli_post');
        });
        Route::prefix('kayitlar')->group(function () {
            Route::get('ogrenci', [OgrenciController::class, 'list'])->name('admin_list_ogrenci');
            Route::post('ogrenci', [OgrenciController::class, 'get'])->name('admin_get_ogrenci');
            Route::get('veli', [VeliController::class, 'list'])->name('admin_list_veli');
            Route::post('veli', [VeliController::class, 'get'])->name('admin_get_veli');
        });
        Route::prefix('kurumlar')->group(function () {
            Route::get('/', [kurumController::class, 'list'])->name('admin_list_kurum');
            Route::get('olustur', [kurumController::class, 'create'])->name('admin_create_kurum');
            Route::post('olustur', [kurumController::class, 'create_post'])->name('admin_create_kurum_post');
            Route::get('duzenle/{id}', [kurumController::class, 'edit'])->name('admin_edit_kurum');
            Route::post('get', [kurumController::class, 'get'])->name('admin_get_kurum');
        });
        Route::prefix('ogretmenler')->group(function () {
            Route::post('show_bekleyen', [ogretmenController::class, 'show_bekleyen'])->name('admin_show_ogretmen_bekleyen');
            Route::post('onayla', [ogretmenController::class, 'onayla'])->name('admin_onayla_ogretmen');
            Route::post('reddet', [ogretmenController::class, 'reddet'])->name('admin_reddet_ogretmen');
            Route::get('bekleyenler', [ogretmenController::class, 'get_bekleyenler'])->name('admin_bekleyen_ogretmen');
            Route::get('aktif', [ogretmenController::class, 'aktifList'])->name('admin_aktif_ogretmen_list');
        });
    });
    Route::prefix('veli')->middleware('role:Veli')->group(function () {
        Route::get('/', [VeliController::class, 'dashboard'])->name('veli_dash');
    });
    Route::prefix('ogrenci')->middleware('role:Öğrenci')->group(function () {
        Route::get('/', [OgrenciController::class, 'dashboard'])->name('ogrenci_dash');
    });
    Route::prefix('ogretmen')->middleware('role:Öğretmen')->group(function () {
        Route::get('/', [ogretmenController::class, 'dashboard'])->name('ogretmen_dash');
        Route::get('talepler', [talepController::class, 'list'])->name('ogretmen_talep_list');
        Route::post('talepSonuclandir', [talepController::class, 'sonuclandir'])->name('ogretmen_talep_sonuclandir');
    });
    Route::prefix('kurum')->middleware('role:Kurum Yetkilisi')->group(function () {
        Route::get('/', [kurumController::class, 'dashboard'])->name('kurum_dash');
        Route::get('loglar/{cid?}', [kurumLogController::class, 'index'])->name('kurum_loglar');
        Route::prefix('ogretmen')->group(function () {
            Route::get('atamaBekleyenler', [KurumOgretmenController::class, 'atamaBekleyenler'])->name('kurum_ogretmen_bekleyenler');
            Route::post('atamaBekleyenler', [KurumOgretmenController::class, 'show_bekleyen'])->name('kurum_ogretmen_bekleyenler_show');
            Route::post('atamaBekleyenler_talep', [KurumOgretmenController::class, 'talep_et'])->name('kurum_ogretmen_bekleyenler_talep');
        });
        Route::prefix('okul')->group(function () {
            Route::get('/', [kurumOkulController::class, 'index'])->name('kurum_okul_index');
            Route::post('ekle', [kurumOkulController::class, 'add'])->name('kurum_okul_add');
        });
        Route::prefix('sinif')->group(function () {
            Route::get('/', [kurumSinifController::class, 'index'])->name('kurum_sinif_index');
            Route::get('/{id}', [kurumSinifController::class, 'show'])->name('kurum_sinif_show');
            Route::post('getOkulData', [kurumOkulController::class, 'getOgrenciler'])->name('kurum_getData_ogrenci_from_school');
            Route::post('ogrenciEkleTc', [kurumSinifController::class, 'ogrenciEkleTc'])->name('kurum_sinif_add_ogrenci_tc');
            Route::post('ekle', [kurumSinifController::class, 'add'])->name('kurum_sinif_add');
            Route::post('cikar', [kurumSinifController::class, 'ogrenciCikar'])->name('kurum_sinif_remove');
            Route::post('get', [kurumSinifController::class, 'get'])->name('kurum_sinif_get');
            Route::post('topluEkle', [kurumSinifController::class, 'ogrenciEkleToplu'])->name('kurum_sinif_toplu_ekle_ogrenci');
        });
        Route::prefix('hesap-olustur')->group(function () {
            Route::get('ogrenci', [kurumOgrenciController::class, 'hesapOlustur'])->name('kurum_hesapOlustur_ogrenci');
            Route::post('ogrenci', [kurumOgrenciController::class, 'hesapOlustur_post'])->name('kurum_hesapOlustur_ogrenci_post');
            Route::post('getSinifFromOkul', [kurumSinifController::class, 'getSiniflar'])->name('kurum_get_sinif_from_okul');
            Route::post('getIlIlceFromOkul', [kurumOkulController::class, 'getIlIlceFromOkul'])->name('kurum_get_ililce_from_okul');
            Route::get('veli', [kurumVeliController::class, 'hesapOlustur'])->name('kurum_hesapOlustur_veli');
            Route::post('veli', [kurumVeliController::class, 'hesapOlustur_post'])->name('kurum_hesapOlustur_veli_post');
        });
        Route::prefix('ders')->group(function () {
            Route::get('/', [kurumDersController::class, 'index'])->name('kurum_ders_index');
            Route::post('ekle', [kurumDersController::class, 'add'])->name('kurum_ders_add');
            Route::get('/{id}', [kurumDersController::class, 'show'])->name('kurum_ders_show');
            Route::post('atamaYap', [KurumOgretmenController::class, 'derse_ata'])->name('kurum_ders_atamayap');
            Route::post('atamaKaldir', [KurumOgretmenController::class, 'atamaKaldir'])->name('kurum_ders_atamakaldir');

        });
        Route::prefix('DersPlani')->group(function () {
            Route::get('/', [kurumDersPlaniController::class, 'index'])->name('kurum_dersPlani_index');
            Route::get('olustur', [kurumDersPlaniController::class, 'create'])->name('kurum_dersPlani_create');
            Route::post('olustur', [kurumDersPlaniController::class, 'insert'])->name('kurum_dersPlani_insert');
        });
    });
});

Route::prefix('parola')->group(function () {
    Route::get('yeni', [onePassController::class, 'changePass'])->name('onePass_change');
    Route::post('yeni', [onePassController::class, 'changePost'])->name('onePass_change_post');
});
