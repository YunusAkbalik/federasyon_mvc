<?php

use App\Models\kurumModel;
use App\Models\kurumUserModel;
use App\Models\ogretmenKurumModel;
use App\Models\User;
use Faker\Factory;

if (!function_exists('ozel_id_uret')) {
    function ozel_id_uret()
    {
        $yearNow = date('y');
        $yearSecond = (string)$yearNow;
        $start = intval($yearSecond[1]) * 100000;
        $end = $start + 99999;
        $ozel_id_exist = true;
        $ozel_id = 0;
        while ($ozel_id_exist) {
            $ozel_id = rand($start, $end);
            if (!(User::where('ozel_id', $ozel_id)->first())) {
                $ozel_id_exist = false;
            }
        }
        return $ozel_id;
    }
}
if (!function_exists('kan_grubu_uret')) {
    function kan_grubu_uret()
    {
        $faker = Factory::create("tr_TR");
        $kan_grubu = $faker->randomElement(['0', 'A', 'B', 'AB']);
        $pozOrNeg = $faker->randomElement(['+', '-']);
        $kan_grubu = $kan_grubu . "RH(" . $pozOrNeg . ")";
        return $kan_grubu;
    }
}
if (!function_exists('get_current_kurum')) {
    function get_current_kurum()
    {
       $kurumUser = kurumUserModel::where('user_id',auth()->user()->id)->first();
       $kurum = kurumModel::find($kurumUser->kurum_id);
       return $kurum;
    }
}
if (!function_exists('get_ogretmen_current_kurum')) {
    function get_ogretmen_current_kurum()
    {
       $kurumOgretmen = ogretmenKurumModel::where('ogretmen_id',auth()->user()->id)->first();
       $kurum = kurumModel::find($kurumOgretmen->kurum_id);
       return $kurum;
    }
}
