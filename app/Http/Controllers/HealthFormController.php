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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;
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
            ->editColumn('group', function (HealthForm $healthForm) {
                return $healthForm->group ? $healthForm->group['name'] : '';})
            ->editColumn('birthday', function (HealthForm $healthForm) {
                return Carbon::parse($healthForm['birthday'])->format('d.m.Y');
            })
            ->editColumn('nickname', function (HealthForm $healthForm) {
                $nickname = $healthForm->nickname;
                return '<a href='.\URL::route('healthform.show',$healthForm).'>'.$nickname.'</a>';
            })
            ->editColumn('code', function (HealthForm $healthForm) {
                if(Auth::user()->isAdmin()) {
                    $healthinfo = Helper::getHealthInfo($healthForm['code']);
                    return '<a href='.\URL::route('healthinformation.show',$healthinfo).'>'. $healthForm->code.'</a>';
                }
                else{
                    return '';
                }
            })
            ->editColumn('finish', function (HealthForm $healthForm) {
                return $healthForm->finish ? 'Ja' : 'Nein';})

            ->addColumn('Actions', function(HealthForm $healthForm) {
                $buttons = '<form action="'.\URL::route('healthforms.open', $healthForm).'" method="post">' . csrf_field();
                if($healthForm['finish']){
                    $buttons .= '  <button type="submit" class="btn btn-secondary btn-sm">Öffnen</button>';
                };
                $buttons .= '</form>';
                return $buttons;
            })
            ->rawColumns(['nickname', 'code', 'Actions'])
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
        $healthinfo = Helper::getHealthInfo($healthform['code']);
        $allergies = $healthinfo->allergies;

        return view('healthform.show', compact('healthform', 'healthinfo', 'allergies'));

    }

    public function downloadPDF(HealthForm $healthform)
    {
        $healthinfo = Helper::getHealthInfo($healthform['code']);
        $allergies = $healthinfo->allergies;
        return view('healthform.print', compact('healthform', 'healthinfo', 'allergies'));
    }

    public function open(HealthForm $healthform)
    {
        $input['finish'] = false;
        $healthform->update($input);
        return redirect('/dashboard/healthforms');
    }

    public function edit(Request $request)
    {
        //
        $input = $request->all();
        $healthforms = HealthForm::where('zip_code','=',$input['zip_code'])->get();
        $healthform = null;
        foreach ($healthforms as $act_healthform){
            if($input['code'] == $act_healthform['code']){
                $healthform = $act_healthform;
                break;
            }
        }
        $healthinfo = Helper::getHealthInfo($healthform['code']);
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

    public function update(Request $request, HealthForm $healthform)
    {
        //
        $validator = Validator::make($request->all(), [
            'healthform.file_vaccination' => 'mimes:pdf|max:2000',
            'healthform.file_allergies' => 'mimes:pdf|max:2000',
        ], [
            'healthform.file_vaccination.max' => 'Die maximale Dateigrösse beträgt 2 MB.',
            'healthform.file_allergies.max' => 'Die maximale Dateigrösse beträgt 2 MB.',
            'healthform.file_vaccination.mimes' => 'Nur PDF-Dateien sind erlaubt.',
            'healthform.file_allergies.mimes' => 'Nur PDF-Dateien sind erlaubt.',]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous())
                ->withErrors($validator)
                ->withInput();
        }
        $input = $request->all();
        $input_healthform = $input['healthform'];
        $input_healthinfo = $input['healthinfo'];
        $input_allergies = $input['allergies'];

        if($file_vaccination = $request->file('healthform.file_vaccination')) {
            $save_path = 'files/' . $healthform['code'];
            if (!file_exists(storage_path('app/'.$save_path))) {
                mkdir(storage_path('app/'.$save_path), 0755, true);
            }
            $name = 'Impfausweis.' . $file_vaccination->getClientOriginalExtension();

            $file_vaccination->move(storage_path('app/'.$save_path), $name);
            $input_healthform['file_vaccination'] = $save_path . '/' . $name;
        }

        if($file_allergies = $request->file('healthform.file_allergies')) {
            $save_path = 'app/files/' . $healthform['code'];
            if (!file_exists(storage_path($save_path))) {
                mkdir(storage_path($save_path), 0755, true);
            }
            $name = 'Allergiepass.' . $file_allergies->getClientOriginalExtension();

            $file_allergies->move(storage_path($save_path), $name);
            $input_healthform['file_allergies'] = $save_path . '/' . $name;
        }

        $healthinfo = Helper::getHealthInfo($healthform['code']);

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
        $input_healthinfo['ointment_only_contact'] = isset($input_healthinfo['ointment_only_contact']);
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

    public function downloadVaccination(HealthForm $healthform)
    {
        //
        return response()->download(storage_path($healthform['file_vaccination']));
    }

    public function downloadAllergy(HealthForm $healthform)
    {
        //
        return response()->download(storage_path($healthform['file_allergy']));
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

    public function searchResponseCity(Request $request)
    {
        // $query = $request->get('term','');
        $cities = City::search($request->get('term'))->get();
        return $cities;
    }
}
