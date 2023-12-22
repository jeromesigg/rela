<?php

namespace App\Helper;


use App\Models\Camp;
use App\Models\CampUser;
use App\Models\Group;
use App\Models\HealthInformation;
use App\Models\User;
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

    static function updateGroup($master, $group_text)
    {
        $group = Group::where('name', '=', $group_text)->first();
        if (isset($group)) {
            $master->update(['group_id' => $group['id']]);
        } else {
            $master->update(['group_id' => null]);
        }
}

    public static function updateCamp(User $user, Camp $camp)
    {
        $camp_user = CampUser::firstOrCreate(['camp_id' => $camp->id, 'user_id' => $user->id]);
        $role_id = $camp_user['role_id'];
        if ($role_id === null) {
            $role_id = $camp['global_camp'] ? config('status.role_Teilnehmer') : $user['role_id'];
        }
        $camp_user->update([
            'role_id' => $role_id,
        ]);
        $user->update([
            'camp_id' => $camp->id,
            'role_id' => $camp_user->role->id,
        ]);
    }

    public static function generateUniqueCode(): int
    {
        do {
            $code = random_int(100000, 999999);
        } while (HealthInformation::where('code', "=", $code)->first());
        return $code;
    }

    public static function generateUniqueCampCode(): int
    {
        do {
            $code = random_int(1000, 9999);
        } while (Camp::where('code', "=", $code)->first());
        return $code;
    }
}
