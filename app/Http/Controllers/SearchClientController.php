<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Mail;
use Storage;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SearchClientController extends Controller
{
    public function searchClient()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get logged-in user
        $user = Auth::user();

        // Check if the user is a Garage Owner
        if ($user->user_type !== 'Super Admin') {
            abort(403, 'Unauthorized');
        }

        $users = User::where('user_type', "User")->get();
        return view('admin.clients.search-client', compact('users'));
    }

    public function getSearchClientData(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // Get logged-in user
        $user = Auth::user();

        // Check if the user is a Garage Owner
        if ($user->user_type !== 'Super Admin') {
            abort(403, 'Unauthorized');
        }

        $clients = User::where('user_type', 'User')
                    ->whereNull('deleted_at')
                    ->leftJoin('tbl_countries', 'users.country_id', '=', 'tbl_countries.id')
                    ->select('users.*', 'tbl_countries.name as country_name')
                    ->orderBy('users.id', 'desc');

        return DataTables::of($clients)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('tbl_countries.name', 'like', "%{$search}%")
                        ->orWhere('users.mobilenumber', 'like', "%{$search}%")
                        ->orWhere('tbl_countries.name', 'like', "%{$search}%")
                        ->orWhere('users.zip', 'like', "%{$search}%")
                        ->orWhere('users.user_status', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('name', fn($user) => $user->name)
            ->addColumn('email', fn($user) => $user->email)
            ->addColumn('mobilenumber', fn($user) => $user->mobilenumber)
            ->addColumn('country_name', fn($user) => $user->country_name)
            ->addColumn('zip', fn($user) => $user->zip)
            ->addColumn('user_status', function ($owner) {
                if( $owner->user_status == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', fn($user) =>
                '<a href="#" title="View Client Details" class="btn btn-soft-primary btn-border btn-icon shadow-none"><i class="ri-eye-line"></i></a>'
            )
            ->rawColumns(['user_status', 'action'])
            ->make(true);
    }
}
