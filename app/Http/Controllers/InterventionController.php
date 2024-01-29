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
        $healthinfo = HealthInformation::where('id','=',$input['info'])->first();
        $interventions = $camp->interventions()
            ->when($healthinfo, function($query, $healthinfo){
                $query->where('health_information_id','=',$healthinfo['id']);})
            ->get();

        return DataTables::of($interventions)
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
                return Carbon::parse($intervention['date'])->format('d.m.Y');
            })
            ->addColumn('intervention', function (intervention $intervention) {
                $text = '1. '.$intervention['parameter'].'<br>';
                $text .= '2. ' . $intervention['value'];
                $text .= isset($intervention['medication']) ? '<br>3. ' . $intervention['medication'] : '';
                return $text;
            })
            ->addColumn('actions', function (intervention $intervention) {
                $close = isset($intervention['date_close']) ? '' : '&emsp;<a href='.\URL::route('interventions.close',$intervention).'><i class="fa-solid fa-heart-circle-check fa-xl"></i></a>';
                return '<a href='.\URL::route('interventions.edit',$intervention).'><i class="fa-regular fa-pen-to-square fa-xl"></i></a>' . $close;
            })
            ->rawColumns(['code', 'picture', 'intervention', 'status', 'abschluss','actions'])
            ->make(true);

    }

    public function close(Intervention $intervention)
    {
        $healthinformation = $intervention->health_information;
        $title = 'J+S-Patientenprotokoll';
        $subtitle = 'von ' . $healthinformation['code'];
        $help = Help::where('title',$title)->first();
        $help['main_title'] = 'Teilnehmerübersicht';
        $help['main_route'] =  '/dashboard/healthinformation';
        $health_status = HealthStatus::pluck('name', 'id')->all();

        if(!isset($intervention['date_close'])){
            $intervention['date_close'] = Carbon::now()->toDateString();
            $intervention['time_close'] = Carbon::now()->toTimeString();
        }
        return view('dashboard.healthinformation.show', compact('healthinformation',  'intervention', 'help', 'title', 'subtitle', 'health_status'));
    }

    public function create(Request $request)
    {
        //
        $input = $request->all();
        if($input['code']) {
            $healthinfo = HealthInformation::where('code', '=', $input['code'])->first();
            if ($healthinfo == null) {
                return redirect()->to(url()->previous())
                    ->withErrors('Es konnte kein Teilnehmer mit diesen Angaben gefunden werden.')
                    ->withInput();
            }
            $intervention = new intervention([
                'health_information_id' => $healthinfo['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        else{
            $intervention = new intervention([
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        $healthinfos = HealthInformation::get()->sortBy('code')->pluck('code','id');
        return view('dashboard.interventions.create', compact('intervention', 'healthinfos'));
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
        }
        else{
            Intervention::create($input);
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
        $healthinformation = $intervention->health_information;
        $title = 'J+S-Patientenprotokoll';
        $subtitle = 'von ' . $healthinformation['code'];
        $help = Help::where('title',$title)->first();
        $help['main_title'] = 'Teilnehmerübersicht';
        $help['main_route'] =  '/dashboard/healthinformation';
        $health_status = HealthStatus::pluck('name', 'id')->all();
        return view('dashboard.healthinformation.show', compact('healthinformation',  'intervention', 'help', 'title', 'subtitle', 'health_status'));

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

