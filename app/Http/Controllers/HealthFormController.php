<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Allergy;
use App\Models\AllergyHealthInformation;
use App\Models\City;
use App\Models\Group;
use App\Models\HealthForm;
use App\Models\HealthInformation;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Ixudra\Curl\Facades\Curl;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class HealthFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.healthform.index');
    }

    public function createDataTables()
    {
        //
        $healthForm = HealthForm::get();

        return DataTables::of($healthForm)
            ->addColumn('group', function (HealthForm $healthForm) {
                return $healthForm->group ? $healthForm->group['name'] : '';})
            ->addColumn('nickname', function (HealthForm $healthForm) {
                $nickname = $healthForm->nickname;
                return '<a href='.\URL::route('healthform.show',$healthForm).'>'.$nickname.'</a>';
                })
            ->addColumn('code', function (HealthForm $healthForm) {
                if(Auth::user()->isAdmin()) {
                    return Crypt::decryptString($healthForm->code);
                }
                else{
                    return '';
                }
            })
            ->addColumn('finish', function (HealthForm $healthForm) {
                return $healthForm->finish ? 'Ja' : 'Nein';})
            ->rawColumns(['nickname'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $groups = Group::on('mysql_info')->pluck('name', 'id')->all();
        return view('dashboard.healthform.create', compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $code = $this->generateUniqueCode();
        $input['code'] = Crypt::encryptString($code);
        HealthForm::create($input);
        HealthInformation::create(['code' => Crypt::encryptString($code)]);

        return view('dashboard.healthform.index');
    }

    public function import(){
            $response = Curl::to('https://db.cevi.ch/groups/' . config('app.group_id'). '/events/' . config('app.event_id'). '/participations.json')
                ->withData(array('token' => config('app.token')))
                ->get();
            $response = json_decode($response);
            $participants = $response->event_participations;
            foreach($participants as $participant){
                $user = User::where('id','=',$participant->id)->first();
                if(!$user){
                    $group = Group::on('mysql_info')->where('id','=', $participant->ortsgruppe_id)->first();
                    if(!$group){
                        $group_id = 2;
                    }
                    else{
                        $group_id = $group['id'];
                    }
                    $code = $this->generateUniqueCode();
                    $insertData = array(
                        'id' => $participant->id,
                        'code' => Crypt::encryptString($code),
                        'nickname' =>  $participant->nickname ? $participant->nickname : $participant->first_name,
                        'last_name' => $participant->last_name,
                        'first_name' => $participant->first_name,
                        'street' => $participant->address,
                        'zip_code' => $participant->zip_code,
                        'city' => $participant->town,
                        'group_id' => $group_id,
                        'birthday' => $participant->birthday,
                    );
                    HealthForm::create($insertData);
                    HealthInformation::create(['code' => $code]);
                }
            }
            return true;
    }

    public function generateUniqueCode(): int
    {
        do {
            $code = random_int(1000, 9999);
        } while (HealthForm::where('code', "=", $code)->first());

        return $code;
    }

    public function show(HealthForm $healthform)
    {
        //
        $healthinfo = Helper::getHealthInfo(Crypt::decryptString($healthform['code']));
        $allergies = $healthinfo->allergies;

        return view('healthform.show', compact('healthform', 'healthinfo', 'allergies'));

    }

    public function downloadPDF(HealthForm $healthform)
    {
        $healthinfo = Helper::getHealthInfo(Crypt::decryptString($healthform['code']));
        $allergies = $healthinfo->allergies;
        return view('healthform.print', compact('healthform', 'healthinfo', 'allergies'));
    }

    public function edit(Request $request)
    {
        //
        $input = $request->all();
        $healthforms = HealthForm::where('zip_code','=',$input['zip_code'])->get();
        $healthform = null;
        foreach ($healthforms as $act_healthform){
            if($input['code'] == Crypt::decryptString($act_healthform['code'])){
                $healthform = $act_healthform;
                break;
            }
        }
        $healthinfo = Helper::getHealthInfo(Crypt::decryptString($healthform['code']));
        $allergyHealthInformation = $healthinfo->allergies;
        if (count($allergyHealthInformation)==0){
            $allergies = Allergy::get();
            foreach ($allergies as $allergy){
                AllergyHealthInformation::create([
                    'health_information_id' => $healthinfo['id'],
                    'allergy_id' => $allergy['id']]);
            }
        }
        $allergies = AllergyHealthInformation::where('health_information_id','=',$healthinfo['id'])->get();
//
        if ($healthform == null) {
            return redirect()->to(url()->previous())
                ->withErrors('Es konnte kein Gesundheitsblatt mit diesen Angaben gefunden werden.')
                ->withInput();
        }
        elseif($healthform['finish']) {
            return view('healthform.show', compact('healthform', 'healthinfo', 'allergies'));
        }
        else{
            return view('healthform.edit', compact('healthform', 'healthinfo', 'allergies'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Health_Form  $health_Form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthForm $healthform)
    {
        //
        $input = $request->all();
        $input_healthform = $input['healthform'];
        $input_healthinfo = $input['healthinfo'];
        $input_allergies = $input['allergies'];

        $healthinfo = Helper::getHealthInfo(Crypt::decryptString($healthform['code']));

        $input_healthform['swimmer'] = isset($input_healthform['swimmer']);
        if($input['submit_btn'] == 'Gesundheitsblatt abschliessen') {
            $finish = true;
            $message = 'Dein Gesundheitsblatt wurde übermittelt, vielen Dank.';
        }
        else{
            $finish = false;
            $message = 'Vielen Dank für die Eingaben. Dein Gesundheitsblatt wurde aktualisiert.';
        }
        $input_healthform['finish'] = $finish;
        $input_healthinfo['drugs_only_contact'] = isset($input_healthinfo['drugs_only_contact']);
        $healthform->update($input_healthform);
        $healthinfo->update($input_healthinfo);
        $allergies = $healthinfo->allergies;

        foreach ($allergies as $index => $allergy){
            $allergy->update(['comment' => $input_allergies[$index]]);
        }
        if($finish){
            return redirect()->route('healthform.show', $healthform);
        }
        else {
            return redirect()->to('/')->with('success', $message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Health_Form  $health_Form
     * @return \Illuminate\Http\Response
     */
    public function destroy(Health_Form $health_Form)
    {
        //
    }
}
