<?php

namespace App\Http\Controllers;

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
    public function __construct()
    {
        $this->middleware('auth');
    }

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
        return view('home', compact('intervention_classes', 'camp'));
    }
}
