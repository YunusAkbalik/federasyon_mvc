<?php

namespace App\Providers;

use App\Models\ogretmenKurumModel;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        view()->composer('layouts.backend', function ($view) {
            $yeniKayitAdeti = User::role('Öğrenci')->where('onayli', false)->where('ret', false)->count();
            $yeniKayitAdeti += User::role('Veli')->where('onayli', false)->where('ret', false)->count();
            $bekleyenOgretmenCount = User::role('Öğretmen')->where('onayli', false)->where('ret', false)->count();
            $ogretmen_kurum_exist = false;
            if (Auth::check()) {
                $ogretmen_kurum_exist = ogretmenKurumModel::where('ogretmen_id', auth()->user()->id)->first() ? true : false;
            }
            $view->with([
                'yeniKayitAdeti' => $yeniKayitAdeti,
                'bekleyenOgretmenCount' => $bekleyenOgretmenCount,
                'ogretmen_kurum_exist' => $ogretmen_kurum_exist
            ]);
        });
    }
}
