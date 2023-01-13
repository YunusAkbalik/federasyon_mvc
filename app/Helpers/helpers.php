<?php

use App\Models\User;

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
