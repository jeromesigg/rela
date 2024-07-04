<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Camp;
use App\Models\HealthInformation;
use App\Models\HealthStatus;
use App\Models\Help;
use App\Models\Intervention;
use App\Models\InterventionClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

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
            ->addColumn('intervention', function (intervention $intervention) {
                $text = '1. '.$intervention['parameter'].'<br>';
                $text .= '2. ' . $intervention['value'];
                $text .= isset($intervention['medication']) ? '<br>3. ' . $intervention['medication'] : '';
                return $text;
            })
            ->addColumn('actions', function (intervention $intervention) {
                $close =  '';
                if(!isset($intervention['date_close'])){
                    if(!isset($intervention['intervention_master_id'])){
                        $close = '&emsp;<a href='.\URL::route('interventions.create',['healthInformation' => $intervention->health_information, 'intervention' => $intervention]).'><i class="fa-solid fa-indent fa-xl"></i></i></a>&emsp;<a href='.\URL::route('interventions.close',$intervention).'><i class="fa-solid fa-heart-circle-check fa-xl"></i></a>';
                    }
                    else{
                        $close = '&emsp;<a href='.\URL::route('interventions.close',$intervention).'><i class="fa-solid fa-heart-circle-check fa-xl"></i></a>';
                    }
                }
                return '<a href='.\URL::route('interventions.edit',$intervention).'><i class="fa-regular fa-pen-to-square fa-xl"></i></a>' . $close;
            })
            ->rawColumns(['code', 'picture', 'intervention', 'status', 'abschluss','actions', 'date'])
            ->make(true);

    }

    public function close(Intervention $intervention)
    {
        if(!isset($intervention['date_close'])){
            $intervention['date_close'] = Carbon::now()->toDateString();
            $intervention['time_close'] = Carbon::now()->toTimeString();
        }
        return Helper::getHealthInformationShow($intervention);
    }

    public function create(HealthInformation $healthInformation, Intervention $intervention)
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
                $interventions = $intervention->interventions();
                foreach($interventions as $intervention_slave){
                    if(!isset($intervention_slave['date_close'])){
                        $intervention_slave->update([
                            'date_close' => $intervention['date_close'], 
                            'time_close' => $intervention['time_close'], 
                            'comment_close' => $intervention['comment_close'], 
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
                Intervention::create($input);
                $intervention_master->update(['max_serial_number' => $input['serial_number']]);
            }
            else{
                $input['serial_number'] = $camp['max_serial_number'] + 1;
                Intervention::create($input);
                $camp->update(['max_serial_number' => $input['serial_number']]);
            }
        }

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

