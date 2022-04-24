<?php

namespace App\Http\Controllers;

use App\Models\HealthInformation;
use App\Models\HealthStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HealthInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.healthinformation.index');
    }

    public function createDataTables()
    {
        //
        $healthinfo = HealthInformation::get();

        return DataTables::of($healthinfo)
            ->addColumn('code', function (HealthInformation $act_healthinfo) {
                return '<a href='.\URL::route('healthinformation.show',$act_healthinfo).'>'.$act_healthinfo['code'].'</a>';
            })
            ->addColumn('allergies', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->allergies);
            })
            ->addColumn('monitorings', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->monitorings);
            })
            ->addColumn('medications', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->medications);
            })
            ->addColumn('measures', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->measures);
            })
            ->addColumn('surveillances', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->surveillances);
            })
            ->addColumn('healthstatus', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->healthstatus);
            })
            ->addColumn('incidents', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->incidents);
            })
            ->rawColumns(['code'])
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        return view('dashboard.healthinformation.show', compact('healthinformation'));

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
