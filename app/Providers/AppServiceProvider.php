<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Pagination\Paginator;
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
            $yeniKayitAdeti = User::role('Öğrenci')->where('onayli', false)->count();
            $yeniKayitAdeti += User::role('Veli')->where('onayli', false)->count();
            $view->with('yeniKayitAdeti', $yeniKayitAdeti);
        });
    }
}
