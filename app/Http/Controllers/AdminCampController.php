<?php

namespace App\Http\Controllers;

use App\Events\CampCreated;
use App\Helper\Helper;
use App\Models\Camp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminCampController extends Controller
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
        $aktUser = Auth::user();
        if (! $aktUser) {
            return redirect('/dashboard');
        }
        if (! $aktUser->isAdmin()) {
            if (isset($aktUser->camp)) {
                $camps = [$aktUser->camp];
            } else {
                $camps = null;
            }
        } else {
            $camps = Camp::all();
        }
        $title = 'Lagerübersicht';

        return view('dashboard.camps.index', compact('camps', 'title'));
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
        $input = $request->all();

        if (!Auth::user()->demo) {
            $user = User::findOrFail(Auth::user()->id);

            if (!$user->isAdmin()) {
                $input['user_id'] = $user->id;
            }
            $camp = Camp::create($input);
            CampCreated::dispatch($camp);
            if (!$user->isAdmin()) {
                $user->update(['camp_id' => $camp->id]);
            }
        }

        return redirect('dashboard/camps');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Camp $camp)
    {
        //
        $users = User::where('role_id', config('status.role_Lagerleiter'))->pluck('username', 'id')->all();

        return view('dashboard.camps.edit', compact('camp', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Camp $camp)
    {
        if (!Auth::user()->demo) {
            $input = $request->all();
            $camp->update($input);
        }

        return redirect('/dashboard/camps');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Camp $camp)
    {
        if (!Auth::user()->demo) {
            $users = Auth::user()->camp->allUsers;
            $camp_global = Camp::where('global_camp', true)->first();


            foreach ($users as $user) {
                Helper::updateCamp($user, $camp_global);
            }
            foreach ($camp->camp_users_all()->get() as $camp_user) {
                $camp_user->delete();
            }
            $counter = $camp->health_infos()->count();
            foreach ($camp->health_infos()->get() as $health_info) {
                $health_info->delete();
            }
            foreach ($camp->health_forms()->get() as $health_form) {
                $health_form->delete();
            }

            File::deleteDirectory(storage_path('app/public/files/' . $camp['code']));
            File::deleteDirectory(storage_path('app/files/' . $camp['code']));
            $camp->update(['finish' => true, 'counter' => $counter]);
        }

        return redirect('/dashboard');
    }

}
