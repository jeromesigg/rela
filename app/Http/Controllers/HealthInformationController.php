<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Camp;
use App\Models\HealthForm;
use App\Models\HealthInformation;
use App\Models\Help;
use App\Models\Intervention;
use App\Models\InterventionClass;
use Auth;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;
use Yajra\DataTables\Facades\DataTables;
use Validator;

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
        $title = 'Teilnehmerübersicht';
        $help = Help::where('title',$title)->first();
        return view('dashboard.healthinformation.index', compact('title', 'help'));
    }

    public function createDataTables()
    {
        //
        $camp = Auth::user()->camp;
        $healthinfo = HealthInformation::where('camp_id', '=', $camp['id'])->get();

        return DataTables::of($healthinfo)
            ->addColumn('code', function (HealthInformation $act_healthinfo) {
                return '<a href='.\URL::route('healthinformation.show',$act_healthinfo).'>'.$act_healthinfo['code'].'</a>';
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
            ->addColumn('incidents', function (HealthInformation $act_healthinfo) {
                return count($act_healthinfo->incidents);
            })
            ->addColumn('status', function (HealthInformation $act_healthinfo) {
                return $act_healthinfo->health_status ? $act_healthinfo->health_status['name'] : '';
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
        $intervention = new Intervention([
            'health_information_id' => $healthinformation['id'],
            'date' => Carbon::now()->toDateString(),
            'time' => Carbon::now()->format('H:i'),
            'user_erf' => Auth::user()->username,
        ]);
        $intervention_class = InterventionClass::first();
        $intervention_classes_all = InterventionClass::where('show',true)->get();
        $intervention_classes = InterventionClass::where('show',true)->pluck('short_name','id');
        $title = 'J+S-Patientenprotokoll';
        $subtitle = 'von ' . $healthinformation['code'];
        $help = Help::where('title',$title)->first();
        $help['main_title'] = 'Teilnehmerübersicht';
        $help['main_route'] =  '/dashboard/healthinformation';
        return view('dashboard.healthinformation.show', compact('healthinformation', 'intervention_classes', 'intervention_classes_all', 'intervention', 'intervention_class', 'title', 'help', 'subtitle'));

    }

    public function search(Request $request)
    {
        //
        $input = $request->all();
        $healthinfo = null;
        $camp = Auth::user()->camp;
        if($input['code']) {
            $healthinfo = HealthInformation::where('code', '=', $input['code'])->where('camp_id', '=', $camp['id'])->first();
        }
        if ($healthinfo == null) {
            return redirect()->to(url()->previous())
                ->withErrors('Es konnte kein Teilnehmer mit diesen Angaben gefunden werden.')
                ->withInput();
        }
        return redirect()->route('healthinformation.show',[$healthinfo]);

    }

    public function uploadProtocol(Request $request, HealthInformation $healthinformation)
    {
        //
        $validator = Validator::make($request->all(), [
            'file_protocol' => 'mimes:pdf|max:2000',
        ], [
            'file_protocol.max' => 'Die maximale Dateigrösse beträgt 2 MB.',
            'file_protocol.mimes' => 'Nur PDF-Dateien sind erlaubt.',]);

        if ($validator->fails()) {
            return redirect()->to(url()->previous())
                ->withErrors($validator)
                ->withInput();
        }
        $camp = Camp::where('id', $healthinformation['camp_id'])->first();
        if(!$camp['demo'] && $file_protocol = $request->file('file_protocol')) {
            $save_path = 'app/files/' . $camp['code'] .'/' . $healthinformation['code'];
            if (!file_exists(storage_path($save_path))) {
                mkdir(storage_path($save_path), 0755, true);
            }
            $name = 'Notfallblatt.' . $file_protocol->getClientOriginalExtension();

            $file_protocol->move(storage_path($save_path), $name);
            $input_healthform['file_protocol'] = $save_path . '/' . $name;
            $healthinformation->update(['file_protocol' => $input_healthform['file_protocol']]);
        }
        return redirect()->route('healthinformation.show',[$healthinformation]);
    }

    public function downloadProtocol(HealthInformation $healthinformation)
    {
        //
        return response()->download(storage_path($healthinformation['file_protocol']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HealthInformation  $healthInformation
     * @return \Illuminate\Http\Response
     */
    public function edit(HealthInformation $healthinformation)
    {

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

    public function searchResponseCode(Request $request)
    {
        $healthinformations = HealthInformation::search($request->get('term'))->get();
        return $healthinformations;
    }
}
