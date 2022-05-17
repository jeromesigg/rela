<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('dashboard.users.index');
    }

    public function createDataTables()
    {
        //
        if(Auth::user()->isAdmin()) {
            $users = User::get();
        }else
        {
            $users = User::where('is_Admin', '=', false)->get();
        }

        return DataTables::of($users)
            ->addColumn('role', function (User $user) {
                if($user->is_Admin){
                    return 'Admin';
                }
                elseif($user->is_Manager){
                    return 'Leiter';
                }
                else{
                    return 'Helfer';
                }})
            ->addColumn('Actions', function($users) {
                return '<a href='.\URL::route('dashboard.users.edit', $users->id).' type="button" class="btn btn-success btn-sm">Bearbeiten</a>
                <button data-remote='.\URL::route('dashboard.users.destroy', $users->id).' class="btn btn-danger btn-sm">Löschen</button>';
            })
            ->rawColumns(['Actions'])
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
        return view('dashboard.users.create');

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
        if(trim($request->password) == ''){
            $input = $request->except('password');
        }
        else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }
        $input['is_Admin'] = false;
        $input['is_Manager'] = isset($input['is_Manager']);
        $input['is_Helper'] = isset($input['is_Helper']);
        $input['slug'] = Str::slug($input['name']);

        User::create($input);

        return redirect('/dashboard/users');
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
    public function edit($id)
    {
        //
        $user = User::findOrFail($id);

        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::findOrFail($id);

        if(trim($request->password) == ''){
            $input = $request->except('password');
        }
        else{
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
        }
        $input['is_Manager'] = isset($input['is_Manager']);
        $input['is_Helper'] = isset($input['is_Helper']);
        $input['slug'] = Str::slug($input['name']);
        return $request->password;

        $user->update($input);
        return redirect('/dashboard/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        User::findOrFail($id)->delete();
    }
}
