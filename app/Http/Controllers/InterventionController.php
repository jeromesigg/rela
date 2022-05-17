<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\Intervention;
use App\Models\InterventionClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $intervention_classes = interventionClass::pluck('short_name');
        $healthinformation = [];
        return view('dashboard.interventions.index', compact('intervention_classes', 'healthinformation'));
    }

    public function createDataTables(Request $request)
    {
        //
        $input = $request->all();
        $intervention_class = interventionClass::where('short_name','=',$input['filter'])->first();
        $healthinfo = HealthInformation::where('id','=',$input['info'])->first();
        $interventions = intervention::
            when($intervention_class, function($query, $intervention_class){
                $query->where('intervention_class_id','=',$intervention_class['id']);})
            ->when($healthinfo, function($query, $healthinfo){
                $query->where('health_information_id','=',$healthinfo['id']);})
            ->get();

        return DataTables::of($interventions)
            ->addColumn('code', function (intervention $intervention) {
                $healthinfo = $intervention->health_information;
                return '<a href='.\URL::route('healthinformation.show',$healthinfo).'>'.$healthinfo['code'].'</a>';
            })
            ->addColumn('user', function (intervention $intervention) {
                return $intervention->user['name'];
            })
            ->editColumn('date', function (intervention $intervention) {
                return [
                    'display' => Carbon::parse($intervention['date'])->format('d.m.Y'),
                    'sort' => Carbon::parse($intervention['date'])->diffInDays('01.01.2022')
                ];
            })
            ->editColumn('time', function (intervention $intervention) {
                return [
                    'display' => Carbon::parse($intervention['time'])->format('H:i'),
                    'sort' => Carbon::parse($intervention['time'])->diffInSeconds('01.01.2022')
                ];
            })
            ->addColumn('intervention', function (intervention $intervention) {
                return $intervention->intervention_class['name'];
            })
            ->rawColumns(['code'])
            ->make(true);

    }

    public function create(Request $request)
    {
        //
        $input = $request->all();
        $intervention_class = InterventionClass::where('id', '=', $input['intervention_class_id'])->first();
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
        $intervention_classes_all = InterventionClass::get();
        $intervention_classes = InterventionClass::pluck('short_name','id');
        return view('dashboard.interventions.create', compact('intervention', 'healthinfos', 'intervention_class', 'intervention_classes', 'intervention_classes_all'));
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
        intervention::create($input);

        return redirect()->back();

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

