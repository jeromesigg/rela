<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\Observation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HealthStatusController extends Controller
{

    public function index()
    {
        //
        return view('dashboard.healthstatus.index');
    }

    public function createDataTables()
    {
        //
        $healtstatus = Observation::where('observation_class_id','=',config('observation.healthstatus'))->get();

        return DataTables::of($healtstatus)
            ->addColumn('code', function (HealthStatus $act_healthstatus) {
                $healthinfo = $act_healthstatus->health_information;
                return '<a href='.\URL::route('healthstatus.show',$act_healthstatus).'>'.$healthinfo['code'].'</a>';
            })
            ->addColumn('user', function (HealthStatus $act_healthstatus) {
                return $act_healthstatus->user['name'];
            })
            ->addColumn('date', function (HealthStatus $act_healthstatus) {
                return Carbon::parse($act_healthstatus['date'])->format('d.m.Y');
            })
            ->rawColumns(['code'])
            ->make(true);
    }

    public function create(Request $request)
    {
        //
        $input = $request->all();
        if(count($input)>0) {
            $healthinfo = HealthInformation::where('code', '=', $input['code'])->first();
            if ($healthinfo == null) {
                return redirect()->to(url()->previous())
                    ->withErrors('Es konnte kein Teilnehmer mit diesen Angaben gefunden werden.')
                    ->withInput();
            }
            $healthstatus = new HealthStatus([
                'health_information_id' => $healthinfo['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        else{
            $healthstatus = new HealthStatus([
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        $healthinfos = HealthInformation::get()->sortBy('code')->pluck('code','id');
        return view('dashboard.healthstatus.create', compact('healthstatus', 'healthinfos'));
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
        HealthStatus::create($input);

        return redirect('/dashboard/healthstatus');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function show(HealthStatus $healthStatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function edit(HealthStatus $healthStatus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HealthStatus $healthStatus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(HealthStatus $healthStatus)
    {
        //
    }
}
