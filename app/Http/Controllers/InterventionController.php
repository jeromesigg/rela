<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Camp;
use App\Models\Help;
use App\Helper\Helper;
use Illuminate\Support\Str;
use App\Models\HealthStatus;
use App\Models\Intervention;
use Illuminate\Http\Request;
use App\Models\HealthInformation;
use App\Models\InterventionClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\View\Components\AddNewIntervention;
use App\View\Components\InterventionClose;

class InterventionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $healthinformation = [];
        $title = 'Interventionen';
        $help = Help::where('title',$title)->first();
        return view('dashboard.interventions.index', compact( 'healthinformation', 'title', 'help'));
    }

    public function createDataTables(Request $request)
    {
        //
        $camp = Auth::user()->camp;
        $input = $request->all();
        $filter = $input['filter'] === 'master';
        $healthinfo = HealthInformation::where('id','=',$input['info'])->first();
        $interventions = $camp->interventions()
            ->when($filter, function($query){
                $query->whereNull('intervention_master_id');})
            ->when($healthinfo, function($query, $healthinfo){
                $query->where('health_information_id','=',$healthinfo['id']);})
            ->get();

        return DataTables::of($interventions)
            ->addColumn('number', function (intervention $intervention) {
                return $intervention->number();
            })
            ->addColumn('code', function (intervention $intervention) {
                $healthinfo = $intervention->health_information;
                $code = $healthinfo['code'] . Helper::getName($healthinfo);
                return '<a href='.\URL::route('healthinformation.show',$healthinfo).'>'.$code.'</a>';
            })
            ->addColumn('user', function (intervention $intervention) {
                return $intervention->user['name'];
            })
            ->addColumn('status', function (intervention $intervention) {
                $status =  Helper::getHealthStatus($intervention);
                return $status ?? 'Abgeschlossen';
            })
            ->addColumn('abschluss', function (intervention $intervention) {
                if(isset($intervention['date_close'])) {
                    $status = Carbon::parse($intervention['date_close'])->format('d.m.Y') . ' ' . $intervention['time_close'] . ' - ' .$intervention['user_close']  .'<br>';
                    $status .= $intervention['further_treatment'].'<br>';
                    $status .= $intervention['comment_close'];
                }
                else {
                    $status = 'Offen';
                }
                return $status;
            })
            ->addColumn('picture', function (intervention $intervention) {
                if ($intervention['file']) {
                    return '<a href="#" class="intervention_image"><img src="' . Storage::url($intervention['file']) . '" alt="" width="250px"></a>';
                }
                else{
                    return '';
                }
            })
            ->editColumn('date', function (intervention $intervention) {
                return Carbon::parse($intervention['date'])->format('d.m.Y') . '<br>' . $intervention['time'] ;
            })
            ->addColumn('intervention', function (intervention $intervention) use($filter) {
                $text = '1. '.$intervention['parameter'].'<br>';
                $text .= '2. ' . $intervention['value'];
                $text .= isset($intervention['medication']) ? '<br>3. ' . $intervention['medication'] : '';
                if($filter){
                    foreach($intervention->interventions as $intervention_slave){
                        $text .= '<br><div class="mt-2 text-bold">Nr. '.$intervention_slave->number().'</div>';
                        $text .= '1. '.$intervention_slave['parameter'].'<br>';
                        $text .= '2. ' . $intervention_slave['value'];
                        $text .= isset($intervention_slave['medication']) ? '<br>3. ' . $intervention_slave['medication'] : '';
                    }
                }
                return $text;
            })
            ->addColumn('actions', function (intervention $intervention) {
                $actions =  '<a href='.\URL::route('interventions.edit',$intervention).' title="Intervention Bearbeiten"><i class="fa-regular fa-pen-to-square fa-xl"></i></a>';
                if(!isset($intervention['intervention_master_id'])){
                    $actions .= '&emsp;<a href='.\URL::route('interventions.createNew',['healthInformation' => $intervention->health_information, 'intervention' => $intervention]).' title="Untergeordnete Erstellen"><i class="fa-solid fa-indent fa-xl"></i></a>';
                }
                if(!isset($intervention['date_close'])){
                    $actions .= '&emsp;<a href='.\URL::route('interventions.close',$intervention).' title="Intervention Abschliessen"><i class="fa-solid fa-heart-circle-check fa-xl"></i></a>';
                }
                return $actions;
            })
            ->rawColumns(['code', 'picture', 'intervention', 'status', 'abschluss','actions', 'date'])
            ->make(true);

    }

    public function close(Intervention $intervention)
    {
        if(!isset($intervention['date_close'])){
            $intervention['date_close'] = Carbon::now()->toDateString();
            $intervention['time_close'] = Carbon::now()->toTimeString();
            $intervention['to_close'] = true;
        }
        return Helper::getHealthInformationShow($intervention, null, true);
    }

    public function closeAjax(Request $request)
    {
        $input = $request->all();
        if(!isset($input['intervention_id'])){
            $intervention = Intervention::findOrFail($input['intervention_id']);
            if(!isset($intervention['date_close'])){
                $intervention['date_close'] = Carbon::now()->toDateString();
                $intervention['time_close'] = Carbon::now()->toTimeString();
            }
        }
        $component = new InterventionClose(true);
        return $component->render()->with(['close' => true]);
    }

    public function createNew(HealthInformation $healthInformation, Intervention $intervention)
    {
        //
        $intervention = new intervention([
            'intervention_master_id' => $intervention['id'],
            'health_information_id' => $healthInformation['id'],
            'date' => Carbon::now()->toDateString(),
            'time' => Carbon::now()->toTimeString(),
        ]);
        return Helper::getHealthInformationShow($intervention, $healthInformation);
    }
    

    public function addNew(Request $request)
    {
        //
        $input = $request->all();
        $health_status = HealthStatus::pluck('name', 'id')->all();
        $intervention = new intervention([
            'health_information_id' => $input['healthInformation_id'],
            'date' => Carbon::now()->toDateString(),
            'time' => Carbon::now()->toTimeString(),
        ]);
        $component = new AddNewIntervention($health_status, $input['index'], $intervention);
        return $component->render()->with(['healthstatus' => $health_status, 'intervention' => $intervention, 'index' => $input['index']]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        //
        $input = $request->all();
        $user = Auth::user();
        $input['user_id'] = $user['id'];
        $health_information = HealthInformation::findOrFail($input['health_information_id']);
        $camp = Camp::where('id', $health_information['camp_id'])->first();
        if(!$camp['demo'] && $file = $request->file('file')) {

            $save_path = 'files/' . $camp['code'] .'/' . $health_information['code'];
            $directory = storage_path('app/public/'.$save_path);
            if (!File::isDirectory($directory)) {
                File::makeDirectory($directory, 0775, true);
            }
            $name =  Str::uuid() . '_' . str_replace(' ', '', $file->getClientOriginalName());
            Image::make($input['file'])->save($directory.'/'.$name, 80);
            $input['file'] = $save_path . '/' . $name;
        }

        if (isset($input['intervention_id'])){
            $intervention = Intervention::findOrFail($input['intervention_id']);
            $intervention->update($input);
            if(isset($intervention['date_close'])){
                foreach($intervention->interventions as $intervention_slave){
                    if(!isset($intervention_slave['date_close'])){
                        $intervention_slave->update([
                            'date_close' => $intervention['date_close'], 
                            'time_close' => $intervention['time_close'], 
                            'comment_close' => $intervention['comment_close'], 
                            'further_treatment' => $intervention['further_treatment'], 
                            'user_close' => $intervention['user_close']
                        ]);
                    }
                }
            }
        }
        else{
            if(isset($input['intervention_master_id'])){
                $intervention_master = Intervention::findOrFail($input['intervention_master_id']);
                $input['serial_number'] = $intervention_master['max_serial_number'] + 1;
                $intervention = Intervention::create($input);
                $intervention_master->update(['max_serial_number' => $input['serial_number']]);
            }
            else{
                $input['serial_number'] = $camp['max_serial_number'] + 1;
                $intervention = Intervention::create($input);
                $camp->update(['max_serial_number' => $input['serial_number']]);
            }
        }
        if(isset($input['intervention_new'])){
            $new_interventions = $input['intervention_new'];
            $files_new = $request->file('intervention_new');
            foreach($new_interventions as $key => $new_intervention){
                $input_new = $new_intervention;
                $input_new['user_id'] = $user['id'];
                if(isset($intervention['intervention_master_id'])){
                    $input_new['intervention_master_id'] = $intervention['intervention_master_id'];
                }
                else{
                    $input_new['intervention_master_id'] = $intervention['id'];
                }
                
                if(!$camp['demo'] && isset($files_new[$key])) {
                    $file_new = $files_new[$key]['file'];
                    $save_path = 'files/' . $camp['code'] .'/' . $health_information['code'];
                    $directory = storage_path('app/public/'.$save_path);
                    if (!File::isDirectory($directory)) {
                        File::makeDirectory($directory, 0775, true);
                    }
                    $name =  Str::uuid() . '_' . str_replace(' ', '', $file_new->getClientOriginalName());
                    Image::make($input_new['file'])->save($directory.'/'.$name, 80);
                    $input_new['file'] = $save_path . '/' . $name;
                }

                $input_new['serial_number'] = $intervention['max_serial_number'] + 1;
                Intervention::create($input_new);
                $intervention->update(['max_serial_number' => $input_new['serial_number']]);
            }
        }

        if(isset($input['intervention_sub'])){
            $sub_interventions = $input['intervention_sub'];
            $files_sub = $request->file('intervention_sub');
            foreach($sub_interventions as $key => $sub_intervention){
                $input_sub = $sub_intervention;
                $input_sub['user_id'] = $user['id'];
                
                if(!$camp['demo'] && isset($files_sub[$key])) {
                    $file_sub = $files_sub[$key]['file'];
                    $save_path = 'files/' . $camp['code'] .'/' . $health_information['code'];
                    $directory = storage_path('app/public/'.$save_path);
                    if (!File::isDirectory($directory)) {
                        File::makeDirectory($directory, 0775, true);
                    }
                    $name =  Str::uuid() . '_' . str_replace(' ', '', $file_sub->getClientOriginalName());
                    Image::make($input_sub['file'])->save($directory.'/'.$name, 80);
                    $input_sub['file'] = $save_path . '/' . $name;
                }
                $intervention_sub = Intervention::findOrFail($input_sub['intervention_id']);
                $intervention_sub->update($input_sub);

            }
        }

        if(isset($intervention['intervention_master_id'])){
            $intervention_master = Intervention::findOrFail($intervention['intervention_master_id']);
        }
        else{
            $intervention_master = $intervention;
        }
        Helper::UpdateInterventionStatus($intervention_master); 

        return to_route('healthinformation.show',$health_information);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HealthInformation  $healthInformation
     * @return \Illuminate\Http\Response
     */
    public function show(HealthInformation $healthinformation)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HealthInformation  $healthInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(Intervention $intervention)
    {
        //
        return Helper::getHealthInformationShow($intervention);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HealthInformation  $healthInformation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthInformation $healthInformation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HealthInformation  $healthInformation
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthInformation $healthInformation)
    {
        //
    }
}

