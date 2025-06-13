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
        $countries = Country::all();
        // $states = state::all();
        // $cities = city::all();
        return view('garage-owner.clients.index', compact('users', 'countries'));
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
                        ->orWhere('users.zip', 'like', "%{$search}%")
                        ->orWhere('users.mobilenumber', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('name', fn($user) => $user->name)
            ->addColumn('email', fn($user) => $user->email)
            ->addColumn('mobilenumber', fn($user) => $user->mobilenumber)
            ->addColumn('user_type', fn($user) => $user->user_type)
            ->addColumn('country_name', fn($user) => $user->country_name)
            ->addColumn('zip', fn($user) => $user->zip)
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
                '<a href="'.route('garage-owner.client.details', $user->id).'" title="View Client Details" class="btn btn-soft-primary btn-border btn-icon shadow-none"><i class="ri-eye-line"></i></a>
                <a href="'.route('garage-owner.clients.vehicles.page', $user->id).'" title="Manage Vehicles" class="btn btn-soft-primary btn-border btn-icon shadow-none"><i class="ri-car-fill"></i></a>
                <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none editviewclientdetails" title="Edit Client Details" data-bs-toggle="offcanvas" data-bs-target="#sidebarUpdateClient" aria-controls="offcanvasRight" data-id="'.$user->id.'"><i class="ri-edit-line"></i></button>
                <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removeClientNotificationModal" title="Delete Client Details" data-bs-toggle="offcanvas" data-bs-target="#removeClientNotificationModal" aria-controls="offcanvasRight" data-id="'.$user->id.'"><i class="ri-delete-bin-6-line"></i></button>'
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
        return view('garage-owner.clients.detail', compact('clientDetails'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $garageOwner = Auth::user();

        $validator = Validator::make($request->all(), [
            'txtclientname'             => 'required|string|max:100',
            'txtclientemail'            => 'required|email|unique:users,email',
            'txtclientmobilenumber'     => 'required|string|max:15',
            'txtclientcountry'          => 'required|string|max:100',
            'txtclientstate'            => 'required|string|max:100',
            'txtclientcity'             => 'required|string|max:100',
            'txtclientaddress'          => 'required|string|max:255',
            'newclientphonecode'        => 'required|string|max:20',
            'newclientphoneicocode'     => 'required|string|max:20',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $user = new User();
        $user->name             = $request->txtclientname;
        $user->email            = $request->txtclientemail;
        $user->user_type        = "User";
        $user->password         = Hash::make("User@123");
        $user->countryisocode   = $request->newclientphoneicocode;
        $user->countrycode      = $request->newclientphonecode;
        $user->mobilenumber     = $request->txtclientmobilenumber;
        $user->country_id       = $request->txtclientcountry;
        $user->state_id         = $request->txtclientstate;
        $user->city_id          = $request->txtclientcity;
        $user->address          = $request->txtclientaddress;
        $user->garage_owner_id  = $garageOwner->id;
        $user->user_status      = "1";

        if ($request->txtclientlandlinenumber) {
            $user->landlinenumber = $request->txtclientlandlinenumber;
        }        

        $user->save();
    
        return response()->json(['status' => 'success', 'message' => 'New Client data saved successfully.']);
    }

    public function view(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->all(); // Get all input data
        $clientData = User::where('user_type', 'user')->findOrFail($data['userId']);

        $states = state::where("country_id", $clientData["country_id"])->get();
        $cities = city::where("state_id", $clientData["state_id"])->get();

        $client_data = array(
            "id"                =>  $clientData["id"],
            "name"              =>  $clientData["name"],
            "email"             =>  $clientData["email"],
            "countrycode"       =>  $clientData["countrycode"],
            "countryisocode"    =>  $clientData["countryisocode"],
            "mobilenumber"      =>  $clientData["mobilenumber"],
            "landlinenumber"    =>  $clientData["landlinenumber"],
            "address"           =>  $clientData["address"],
            "country_id"        =>  $clientData["country_id"],
            "state_id"          =>  $clientData["state_id"],
            "city_id"           =>  $clientData["city_id"],
            "states"            =>  $states,
            "cities"            =>  $cities,
        );
        return response()->json($client_data);
    }

    public function update(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = User::find($request->updateclientid);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Client not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'txtupdateclientname'             => 'required|string|max:100',
            'txtupdateclientemail'            => 'required|email',
            'txtupdateclientmobilenumber'     => 'required|string|max:15',
            'txtupdateclientcountry'          => 'required|string|max:100',
            'txtupdateclientstate'            => 'required|string|max:100',
            'txtupdateclientcity'             => 'required|string|max:100',
            'txtupdateclientaddress'          => 'required|string|max:255',
            'updateclientphonecode'           => 'required|string|max:20',
            'updateclientphoneicocode'        => 'required|string|max:20',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $user = User::find($request->updateclientid);
        $user->name             = $request->txtupdateclientname;
        $user->email            = $request->txtupdateclientemail;
        $user->countrycode      = $request->updateclientphonecode;
        $user->countryisocode   = $request->updateclientphoneicocode;
        $user->mobilenumber     = $request->txtupdateclientmobilenumber;
        $user->country_id       = $request->txtupdateclientcountry;
        $user->state_id         = $request->txtupdateclientstate;
        $user->city_id          = $request->txtupdateclientcity;
        $user->address          = $request->txtupdateclientaddress;

        if ($request->txtupdateclientlandlinenumber) {
            $user->landlinenumber = $request->txtupdateclientlandlinenumber;
        }        

        $user->save();
    
        return response()->json(['status' => 'success', 'message' => 'Client updated successfully.']);
    }

    public function removedetails(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $client = User::where('user_type', 'User')->find($request->id);
        if (!$client) {
            return response()->json(['status' => 'error', 'message' => 'Client not found'], 404);
        }

        $client->delete(); // now performs soft delete

        return response()->json(['status' => 'success', 'message' => 'Client deleted successfully.']);
    }
}
