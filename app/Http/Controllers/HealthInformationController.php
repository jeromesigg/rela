<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\HealthForm;
use App\Models\HealthInformation;
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
            'time' => Carbon::now()->toTimeString(),
            'user_erf' => Auth::user()->name,
        ]);
        $intervention_class = InterventionClass::first();
        $intervention_classes_all = InterventionClass::where('show',true)->get();
        $intervention_classes = InterventionClass::where('show',true)->pluck('short_name','id');
        return view('dashboard.healthinformation.show', compact('healthinformation', 'intervention_classes', 'intervention_classes_all', 'intervention', 'intervention_class'));

    }

    public function search(Request $request)
    {
        //
        $input = $request->all();
        $healthinfo = null;
        if($input['code']) {
            $healthinfo = HealthInformation::where('code', '=', $input['code'])->first();
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
        if($file_protocol = $request->file('file_protocol')) {
            $save_path = 'app/files/' .  $healthinformation['code'];
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

    public function searchResponseCode(Request $request)
    {
        // $query = $request->get('term','');
        $healthinformations = HealthInformation::search($request->get('term'))->get();
        return $healthinformations;
    }
//
//    public function print(HealthInformation $healthinformation)
//    {
//        $allergies = $healthinformation->allergies;
//        $healthforms = HealthForm::get();
//        foreach ($healthforms as $act_healthform)  {
//            if ($act_healthform['code']==$healthinformation['code']){
//                $healthform = $act_healthform;
//                break;
//            }
//        }
//
//        $pdf = PDF::loadView('dashboard.healthinformation.print', compact('healthform', 'healthinformation', 'allergies'));
//        return $pdf->download('invoice.pdf');
//
//        return view('dashboard.healthinformation.print', compact('healthform', 'healthinformation', 'allergies'));
//        $outputFile = Storage::disk('local')->path('Notfallblatt/'.$healthinformation['code'].'.pdf');
//        // fill data
//        $this->fillPDF(public_path('files/Notfallblatt.pdf'), $outputFile, $healthinformation);
//        //output to browser
//        return response()->file($outputFile);
//    }
//
//    public function fillPDF($file, $outputFile, HealthInformation $healthinformation)
//    {
//        $fpdi = new FPDI;
//        // merger operations
//        $count = $fpdi->setSourceFile($file);
//
//        $healthforms = HealthForm::get();
//        foreach ($healthforms as $act_healthform)  {
//            if ($act_healthform['code']==$healthinformation['code']){
//                $healthform = $act_healthform;
//                break;
//            }
//        }
//
//        $first_column = 180;
//        $second_column = 250;
//        $first_row = 30;
//        $row_height = 6;
//
//
//        $write_array = array(
//            array(
//                'left' => $first_column,
//                'top' => $first_row,
//                'text' => $healthform['last_name']
//            ),
//            array(
//                'left' => $second_column,
//                'top' => $first_row,
//                'text' => $healthform['first_name']
//            ),
//            array(
//                'left' => $first_column,
//                'top' => $first_row + $row_height,
//                'text' => $healthform['street'] . ', ' . $healthform['zip_code'] . ' ' . $healthform['city']
//            ),
//            array(
//                'left' => $first_column,
//                'top' => $first_row + $row_height * 2,
//                'text' => $healthform['phone_number']
//            ),
//            array(
//                'left' => $second_column,
//                'top' => $first_row + $row_height * 2,
//                'text' =>  Carbon::parse($healthform['birthday'])->format('d.m.Y')
//            ),
//            array(
//                'left' => $first_column + 10,
//                'top' => $first_row + $row_height * 3,
//                'text' =>  $healthform['emergency_contact_name'] . ', ' . $healthform['emergency_contact_address'] . ', ' . $healthform['emergency_contact_phone']
//            ),
//        );
//
//
//        for ($i=1; $i<=$count; $i++) {
//            $template   = $fpdi->importPage($i);
//                $size = $fpdi->getTemplateSize($template);
//                $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
//                $fpdi->useTemplate($template);
//                $fpdi->SetFont("helvetica", "", 12);
//                $fpdi->SetTextColor(0, 0, 0);
//            if($i==2) {
//               foreach ($write_array as $write) {
//                   $fpdi->Text($write['left'], $write['top'], $write['text']);
//               }
//            }
//        }
//        return $fpdi->Output($outputFile, 'F');
//    }
}
