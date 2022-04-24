<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\Measure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class MeasureController extends Controller
{
    public function index()
    {
        //
        return view('dashboard.measures.index');
    }

    public function createDataTables()
    {
        //
        $measures = Measure::get();

        return DataTables::of($measures)
            ->addColumn('code', function (Measure $measure) {
                $healthinfo = $measure->health_information;
                return '<a href='.\URL::route('measures.show',$measure).'>'.$healthinfo['code'].'</a>';
            })
            ->addColumn('user', function (Measure $measure) {
                return $measure->user['name'];
            })
            ->addColumn('date', function (Measure $measure) {
                return Carbon::parse($measure['date'])->format('d.m.Y');
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
            $measure = new Measure([
                'health_information_id' => $healthinfo['id'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        else{
            $measure = new Measure([
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
            ]);
        }
        $healthinfos = HealthInformation::get()->sortBy('code')->pluck('code','id');
        return view('dashboard.measures.create', compact('measure', 'healthinfos'));
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
        Measure::create($input);

        return redirect('/dashboard/measures');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function show(Measure $measure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function edit(Measure $measure)
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
    public function update(Request $request, Measure $measure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Monitoring  $monitoring
     * @return \Illuminate\Http\Response
     */
    public function destroy(Measure $measure)
    {
        //
    }
}
