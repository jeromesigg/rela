<?php

namespace App\Helper;


use App\Models\HealthInformation;
use Illuminate\Support\Facades\Crypt;

class Helper
{
    static function getHealthInfo($code)
    {
        $healthinfos = HealthInformation::get();
        $healthinfo = null;
        foreach ($healthinfos as $act_healthinfo){
            if($code == $act_healthinfo['code']){
                $healthinfo = $act_healthinfo;
                break;
            }
        }
        return $healthinfo;
    }
}
