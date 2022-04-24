<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\Surveillance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SurveillanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.surveillance.index');
    }

    public function createDataTables()
    {
        //
        $surveillances = Surveillance::get();

        return DataTables::of($surveillances)
            ->addColumn('code', function (Surveillance $surveillance) {
                $healthinfo = $surveillance->health_information;
                return '<a href='.\URL::route('surveillance.show',$surveillance).'>'.$healthinfo['code'].'</a>';
            })
            ->addColumn('user', function (Surveillance $surveillance) {
                return $surveillance->user['name'];
            })
            ->addColumn('date', function (Surveillance $surveillance) {
                return Carbon::parse($surveillance['date'])->format('d.m.Y');
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
            $surveillance = new Surveillance([
                'health_information_id' => $healthinfo['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        else{
            $surveillance = new Surveillance([
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        $healthinfos = HealthInformation::get()->sortBy('code')->pluck('code','id');
        return view('dashboard.surveillance.create', compact('surveillance', 'healthinfos'));
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
        Surveillance::create($input);

        return redirect('/dashboard/surveillance');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Surveillance  $surveillance
     * @return \Illuminate\Http\Response
     */
    public function show(Surveillance $surveillance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Surveillance  $surveillance
     * @return \Illuminate\Http\Response
     */
    public function edit(Surveillance $surveillance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Surveillance  $surveillance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Surveillance $surveillance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Surveillance  $surveillance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Surveillance $surveillance)
    {
        //
    }
}
