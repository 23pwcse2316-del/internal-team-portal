<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $workspaces = $user->workspaces;
        
        // USE THE NEW VIEW FILE
        return view('dashboard-new', compact('workspaces'));
    }
}