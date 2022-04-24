<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\Medication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MedicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.medications.index');
    }

    public function createDataTables()
    {
        //
        $medications = Medication::get();

        return DataTables::of($medications)
            ->addColumn('code', function (Medication $medication) {
                $healthinfo = $medication->health_information;
                return '<a href='.\URL::route('medications.show',$medication).'>'.$healthinfo['code'].'</a>';
            })
            ->addColumn('user', function (Medication $medication) {
                return $medication->user['name'];
            })
            ->addColumn('date', function (Medication $medication) {
                return Carbon::parse($medication['date'])->format('d.m.Y');
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
            $medication = new Medication([
                'health_information_id' => $healthinfo['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        else{
            $medication = new Medication([
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        $healthinfos = HealthInformation::get()->sortBy('code')->pluck('code','id');
        return view('dashboard.medications.create', compact('medication', 'healthinfos'));
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
        Medication::create($input);

        return redirect('/dashboard/medications');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function show(Medication $medication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Medication $medication)
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
    public function update(Request $request, Medication $medication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medication $medication)
    {
        //
    }
}

