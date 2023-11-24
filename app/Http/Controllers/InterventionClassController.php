<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use App\Models\InterventionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterventionClassController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $interventionClasses = interventionClass::all();
        return view('dashboard.interventionclasses.index', compact('interventionClasses'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InterventionClass $interventionclass)
    {
        //
        return view('dashboard.interventionclasses.edit', compact('interventionclass'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InterventionClass $interventionclass)
    {
        $input = $request->all();
        $input['show'] = isset($input['show']);
        $input['with_picture'] = isset($input['with_picture']);
        $camp = Auth::user()->camp;

        if(!$camp['demo'] && $file = $request->file('file')) {
            $name =  $input['name']. '.' . $file->getClientOriginalExtension();

            $file->move('files/', $name);
            $input['file'] = '/files/' . '/' . $name;
        }

        $interventionclass->update($input);
        return redirect('/dashboard/interventionclasses');
    }

}
