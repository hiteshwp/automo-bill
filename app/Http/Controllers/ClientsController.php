<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\country;
use App\Models\state;
use App\Models\city;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class ClientsController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get logged-in user
        $user = Auth::user();

        // Check if the user is a Garage Owner
        if ($user->user_type !== 'Garage Owner') {
            abort(403, 'Unauthorized');
        }

        $user_id = $user->id;

        $users = User::where('id', $user_id)->get();
        $countries = country::all();
        $states = state::all();
        $cities = city::all();
        return view('clients.index', compact('users', 'countries', 'states', 'cities'));
    }

    public function getClientsData(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

         // Get logged-in user
         $user = Auth::user();

         // Check if the user is a Garage Owner
         if ($user->user_type !== 'Garage Owner') {
             abort(403, 'Unauthorized');
         }

         $id = $user->id;

        $clients = User::where('garage_owner_id', $id)
            ->where('user_type', 'User')
            ->orderBy('id', 'desc');

        return DataTables::of($clients)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('users.mobilenumber', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('name', fn($user) => $user->name)
            ->addColumn('email', fn($user) => $user->email)
            ->addColumn('email', fn($user) => $user->email)
            ->addColumn('email', fn($user) => $user->email)
            ->addColumn('email', fn($user) => $user->email)
            ->addColumn('mobilenumber', fn($user) => $user->mobilenumber)
            ->addColumn('status', function ($owner) {
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
                '<a href="'.route('client.details', $user->id).'" class="btn btn-soft-primary btn-border btn-icon shadow-none"><i class="ri-eye-line"></i></a>
                <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none" title="Edit"><i class="ri-edit-line"></i></button>
                <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function clientdetail($id, Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

         // Get logged-in user
         $user = Auth::user();

         // Check if the user is a Garage Owner
         if ($user->user_type !== 'Garage Owner') {
             abort(403, 'Unauthorized');
         }

        $clientDetails = User::where('id', $id)
                     ->where('user_type', 'user')
                     ->firstOrFail();
        return view('clients.detail', compact('clientDetails'));
    }
}
