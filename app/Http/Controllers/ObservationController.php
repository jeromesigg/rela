<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\Observation;
use App\Models\ObservationClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ObservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $observation_classes = ObservationClass::pluck('short_name');
        $healthinformation = [];
        return view('dashboard.observations.index', compact('observation_classes', 'healthinformation'));
    }

    public function createDataTables(Request $request)
    {
        //
        $input = $request->all();
        $observation_class = ObservationClass::where('short_name','=',$input['filter'])->first();
        $healthinfo = HealthInformation::where('id','=',$input['info'])->first();
        $observations = Observation::
            when($observation_class, function($query, $observation_class){
                $query->where('observation_class_id','=',$observation_class['id']);})
            ->when($healthinfo, function($query, $healthinfo){
                $query->where('health_information_id','=',$healthinfo['id']);})
            ->get();

        return DataTables::of($observations)
            ->addColumn('code', function (Observation $observation) {
                $healthinfo = $observation->health_information;
                return '<a href='.\URL::route('healthinformation.show',$healthinfo).'>'.$healthinfo['code'].'</a>';
            })
            ->addColumn('user', function (Observation $observation) {
                return $observation->user['name'];
            })
            ->editColumn('date', function (Observation $observation) {
                return [
                    'display' => Carbon::parse($observation['date'])->format('d.m.Y'),
                    'sort' => Carbon::parse($observation['date'])->diffInDays('01.01.2022')
                ];
            })
            ->editColumn('time', function (Observation $observation) {
                return [
                    'display' => Carbon::parse($observation['time'])->format('H:i'),
                    'sort' => Carbon::parse($observation['time'])->diffInSeconds('01.01.2022')
                ];
            })
            ->addColumn('observation', function (Observation $observation) {
                return $observation->observation_class['name'];
            })
            ->rawColumns(['code'])
            ->make(true);

    }

    public function create(Request $request)
    {
        //
        $input = $request->all();
        $observation_class = ObservationClass::where('id', '=', $input['observation_class_id'])->first();
        if($input['code']) {
            $healthinfo = HealthInformation::where('code', '=', $input['code'])->first();
            if ($healthinfo == null) {
                return redirect()->to(url()->previous())
                    ->withErrors('Es konnte kein Teilnehmer mit diesen Angaben gefunden werden.')
                    ->withInput();
            }
            $observation = new Observation([
                'observation_class_id' => $observation_class['id'],
                'health_information_id' => $healthinfo['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        else{
            $observation = new Observation([
                'observation_class_id' => $observation_class['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        $healthinfos = HealthInformation::get()->sortBy('code')->pluck('code','id');
        $observation_classes_all = ObservationClass::get();
        $observation_classes = ObservationClass::pluck('short_name','id');
        return view('dashboard.observations.create', compact('observation', 'healthinfos', 'observation_class', 'observation_classes', 'observation_classes_all'));
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
        $user = Auth::user();
        $input['user_id'] = $user['id'];
        Observation::create($input);

        return redirect('/dashboard/observations');

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
    public function edit(HealthInformation $healthinformation)
    {
        //
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

