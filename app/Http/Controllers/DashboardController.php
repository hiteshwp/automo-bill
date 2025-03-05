<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();

        if ($user->user_type === 'Super Admin') {
            return redirect()->route('dashboard.super-admin');
        } elseif ($user->user_type === 'Garage Owner') {
            return redirect()->route('dashboard.garage-owner');
        } else {
            return redirect()->route('dashboard.user');
        }
    }

    public function superAdmin()
    {
        return view('dashboard.super-admin');
    }

    public function garageOwner()
    {
        return view('dashboard.garage-owner');
    }

    public function userDashboard()
    {
        return view('dashboard.user');
    }
}
