<?php

namespace App\Http\Controllers;

use App\Events\CampCreated;
use App\Helper\Helper;
use App\Models\Camp;
use App\Models\CampUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class CampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $users = [];
        $title = 'Kurs erstellen';
        return view('dashboard.camps.create', compact('users',  'title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           $validator = Validator::make($request->all(), [
                    'name' => 'unique:camps',
                ]);

                if ($validator->fails()) {
                    return redirect()->to(url()->previous())
                                ->withErrors($validator, 'camps')
                                ->withInput();
                }
                if (!Auth::user()->demo) {

                    $input = $request->all();

                    $user = User::findOrFail(Auth::user()->id);
                    $input['user_id'] = $user->id;
                    $input['global_camp'] = false;
                    $input['code'] = Helper::generateUniqueCampCode();
                    $camp = Camp::create($input);
                    CampCreated::dispatch($camp);
                    $user->update(['camp_id' => $camp->id, 'role_id' => config('status.role_Kursleiter')]);
                    CampUser::create([
                        'user_id' => $user->id,
                        'camp_id' => $camp->id,
                        'role_id' => config('status.role_Kursleiter'),]);
                }

                return redirect('dashboard');
            }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function show(Camp $camp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function edit(Camp $camp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camp $camp)
    {
        //
        if (!Auth::user()->demo) {
            Helper::updateCamp(Auth::user(), $camp);
        }
        return redirect('/dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Camp  $camp
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camp $camp)
    {
        //
    }
}
