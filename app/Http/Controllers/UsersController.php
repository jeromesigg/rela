<?php

namespace App\Http\Controllers;

use App\Models\HealthForm;
use App\Models\Help;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\Survey;
use App\Models\CampUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(User $user)
    {
        $aktUser = Auth::user();
        if($aktUser &&  ($aktUser->id == $user->id))
        {
            $title = 'Profil';
            $subtitle = 'von ' . $aktUser['username'];
            $help = Help::where('title',$title)->first();
            return view('dashboard.user', compact('aktUser', 'title', 'subtitle', 'help'));
        }
        return redirect('/dashboard');
    }

    public function update(Request $request, User $user)
    {
        if(trim($request->password) == ''){
            $input = $request->except('password');
            $user->update($input);
        }
        else{
            $request->validate([
                'password' => ['required', 'confirmed'],
            ]);
            $input = $request->all();
            $input['password'] = bcrypt($request->password);
            $input['password_change_at'] = now();
            $user->update($input);
            Session::flash('message', 'Passwort erfolgreich verändert!');
        }
        return redirect('/dashboard');
    }
}
