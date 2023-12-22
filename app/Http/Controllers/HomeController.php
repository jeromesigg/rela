<?php

namespace App\Http\Controllers;

use App\Models\Help;
use App\Models\InterventionClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $akt_User = Auth::user();
        $camp = $akt_User->camp;
        $intervention_classes = InterventionClass::pluck('name', 'id');
        $title = 'Dashboard';
        $subtitle = $camp['global_camp'] ? '' : ' für Lager "' . $camp['name'] . '" (' . $camp['code'] . ')';
        $help = Help::where('title',$title)->first();
        return view('dashboard', compact('intervention_classes', 'camp', 'title', 'help', 'subtitle'));
    }

    public function home()
    {
        $title = 'Gesundheitsblatt ausfüllen';
        $help = Help::where('title',$title)->first();
        return view('home', compact('title', 'help'));
    }
}
