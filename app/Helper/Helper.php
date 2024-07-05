<?php

namespace App\Helper;


use Auth;
use App\Models\Camp;
use App\Models\Help;
use App\Models\User;
use App\Models\Group;
use App\Models\CampUser;
use App\Models\HealthForm;
use App\Models\HealthStatus;
use App\Models\Intervention;
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

    static function getHealthForm($code)
    {
        $healthforms = HealthForm::get();
        $healthform = null;
        foreach ($healthforms as $act_healthform){
            if($code == $act_healthform['code']){
                $healthform = $act_healthform;
                break;
            }
        }
        return $healthform;
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

    public static function getHealthStatus(Intervention $intervention){
        $status = null;
        if(!isset($intervention['date_close'])) {
            $red = $intervention['health_status_id'] == config('status.health_red') ? 'red': '';
            $yellow = $intervention['health_status_id'] == config('status.health_yellow') ? 'yellow': '';
            $green = ($intervention['health_status_id'] == config('status.health_green')) || !isset($intervention['health_status_id']) ? 'green': '';

            $status = '<div class="text-center-profile mbl">
                                    <div class="ampel row" id="ampel">
                                        <div class="ampel-btn col-4">
                                            <div class="circle '. $red .'"></div>
                                        </div>
                                        <div class="ampel-btn col-4">
                                            <div class="circle '. $yellow .'"></div>
                                        </div>
                                        <div class="ampel-btn col-4">
                                             <div class="circle '. $green .'"></div>
                                        </div>
                                    </div>
                                </div>';
        }
        return $status;
    }

    public static function getName(HealthInformation $healthInformation)
    {
        $name = '';
        if (Auth::user()->isManager() || Auth::user()->camp['show_names']) {
            $healthForm = Helper::getHealthForm($healthInformation['code']);
            $name = ' (' . $healthForm['nickname'] . ')';
        }
        return $name;
    }

    public static function getHealthInformationShow(Intervention $intervention, HealthInformation $healthinformation = null)
    {
        if($healthinformation === null){
            $healthinformation = $intervention->health_information;
        }
        $title = 'J+S-Patientenprotokoll';
        $subtitle = 'von ' . $healthinformation['code'];
        $help = Help::where('title',$title)->first();
        $help['main_title'] = 'Teilnehmerübersicht';
        $help['main_route'] =  '/dashboard/healthinformation';
        $health_status = HealthStatus::pluck('name', 'id')->all();
        $intervention_masters = ['' => 'Übergeordnete Intervention'] + $healthinformation->interventions_open()->whereNull('intervention_master_id')->pluck('parameter', 'interventions.id')->toArray();
        $camp = Auth::user()->camp;
        return view('dashboard.healthinformation.show', compact('healthinformation',  'intervention', 'help', 'title', 'subtitle', 'health_status', 'intervention_masters', 'camp'));
    }
}
