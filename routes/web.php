<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IlceController;
use App\Http\Controllers\OkulController;
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


Route::match(['get', 'post'], '/', function(){
    return view('dashboard');
})->name('home');

Route::get('ogrenci-kayit', [AuthController::class, 'ogrenci_kayit'])->middleware('guest')->name('ogrenci_kayit');
Route::post('ogrenci-kayit', [AuthController::class, 'ogrenci_kayit_post'])->middleware('guest')->name('ogrenci_kayit_post');
Route::post('getIlceler', [IlceController::class, 'getIlceFromIl'])->name('getIlcelerFromIlID');
Route::post('getOkullar', [OkulController::class, 'getOkulsFromIlce'])->name('getOkullarFromIlceID');

Route::view('/pages/slick', 'pages.slick');
Route::view('/pages/datatables', 'pages.datatables');
Route::view('/pages/blank', 'pages.blank');
