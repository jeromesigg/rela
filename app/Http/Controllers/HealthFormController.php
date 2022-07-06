<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Imports\HealthFormsImport;
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

    public function uploadFile(Request $request){
        if($request->hasFile('file')){

            $array = (new HealthFormsImport)->toArray(request()->file('file'));
            $importData_arr = $array[0];
            foreach($importData_arr as &$importData){
                if(is_numeric($importData['geburtstag'])) {
                    $dayCarbon = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($importData['geburtstag']));
                    $day = Carbon::parse($dayCarbon)->format('Y-m-d');
                    $importData['geburtstag'] = $day;
                }
                else{
                    $day = Carbon::parse($importData['geburtstag'])->format('Y-m-d');
                    $importData['geburtstag'] = $day;

                }
                $importData['ceviname'] = $importData['ceviname'] ? $importData['ceviname'] : $importData['vorname'];

            }

//            return $importData_arr ;
            // Insert to MySQL database
            foreach($importData_arr as $importData){

                $group = Group::where('short_name','=',$importData['abteilung'])->first();
                $code = $this->generateUniqueCode();
                $insertData = array(

                    'code' => Crypt::encryptString($code),
                    'first_name' => $importData['vorname'],
                    'last_name' => $importData['nachname'],
                    'nickname' => $importData['ceviname'],
                    'street' => $importData['strasse'],
                    'zip_code' => $importData['plz'],
                    'city' => $importData['ort'],
                    'birthday' => $importData['geburtstag'],
                    'ahv' => $importData['ahv_nr'],
                    'group_id' => $group ? $group['id'] : null,
                );

                HealthForm::firstOrCreate(['ahv' => $importData['ahv_nr']], $insertData);
                HealthInformation::create(['code' => $code]);
            }
        }

        return redirect()->action('HealthFormController@index');


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
//                        'id' => $participant->id,
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

        return view('healthform.show', compact('healthform', 'healthinfo'));

    }

    public function downloadPDF(HealthForm $healthform)
    {
        $healthinfo = Helper::getHealthInfo($healthform['code']);
        return view('healthform.print', compact('healthform', 'healthinfo'));
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
        $healthforms = HealthForm::where('birthday','=',$input['birthday'])->get();
        $healthform = null;
        foreach ($healthforms as $act_healthform){
            if($input['ahv'] == $act_healthform['ahv']){
                $healthform = $act_healthform;
                $code = $healthform['code'];
                break;
            }
        }

        if ($healthform == null) {
            return redirect()->to(url()->previous())
                ->withErrors('Es konnte kein Gesundheitsblatt mit diesen Angaben gefunden werden.')
                ->withInput();
        }
        $healthinfo = Helper::getHealthInfo($code);
//
        if($healthform['finish']) {
            return view('healthform.show', compact('healthform', 'healthinfo'));
        }
        else{
            return view('healthform.edit', compact('healthform', 'healthinfo'));
        }
    }

    public function update(Request $request, HealthForm $healthform)
    {
        //
        $validator = Validator::make($request->all(), [
            'healthform.file_allergies' => 'mimes:pdf|max:2000',
        ], [
            'healthform.file_allergies.max' => 'Die maximale Dateigrösse beträgt 2 MB.',
            'healthform.file_allergies.mimes' => 'Nur PDF-Dateien sind erlaubt.',]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous())
                ->withErrors($validator)
                ->withInput();
        }
        $input = $request->all();
        $input_healthform = $input['healthform'];
        $input_healthinfo = $input['healthinfo'];

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
        if($finish){
            return redirect()->route('healthform.show', $healthform);
        }
        else {
            return redirect()->to('/')->with('success', $message);
        }
    }

    public function downloadAllergy(HealthForm $healthform)
    {
        //
        return response()->download(storage_path('app/'.$healthform['file_allergy']));
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
