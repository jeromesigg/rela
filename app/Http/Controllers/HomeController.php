<?php

namespace App\Http\Controllers;

use App\Models\InterventionClass;
use Illuminate\Http\Request;

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
        $intervention_classes = InterventionClass::pluck('name', 'id');
        return view('home', compact('intervention_classes'));
    }
}
