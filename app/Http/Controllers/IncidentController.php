<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\Incident;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class IncidentController extends Controller
{
    public function index()
    {
        //
        return view('dashboard.incidents.index');
    }

    public function createDataTables()
    {
        //
        $incidents = Incident::get();

        return DataTables::of($incidents)
            ->addColumn('code', function (Incident $incident) {
                $healthinfo = $incident->health_information;
                return '<a href='.\URL::route('incidents.show',$incident).'>'.$healthinfo['code'].'</a>';
            })
            ->addColumn('user', function (Incident $incident) {
                return $incident->user['name'];
            })
            ->addColumn('date', function (Incident $incident) {
                return Carbon::parse($incident['date'])->format('d.m.Y');
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
            $incident = new Incident([
                'health_information_id' => $healthinfo['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        else{
            $incident = new Incident([
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        $healthinfos = HealthInformation::get()->sortBy('code')->pluck('code','id');
        return view('dashboard.incidents.create', compact('incident', 'healthinfos'));
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
        Incident::create($input);

        return redirect('/dashboard/incidents');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function show(Incident $incident)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Incident $incident)
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
    public function update(Request $request, Incident $incident)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(Incident $incident)
    {
        //
    }
}
