<?php

namespace App\Http\Controllers;

use App\Models\ObservationClass;
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
        $observation_classes = ObservationClass::pluck('name', 'id');
        return view('home', compact('observation_classes'));
    }
}
