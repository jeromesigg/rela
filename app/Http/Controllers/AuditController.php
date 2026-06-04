<?php

namespace App\Http\Controllers;

class AuditController extends Controller
{
    //
    public function index()
    {
        $audits = \OwenIt\Auditing\Models\Audit::with('user')
            ->orderBy('created_at', 'desc')->get();

        return view('dashboard.audits', compact('audits'));
    }
}
