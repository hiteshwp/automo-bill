<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\country;
use App\Models\state;
use App\Models\city;
use Yajra\DataTables\DataTables;

class GarageOwnerController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $garageOwners = User::where('user_type', 'Garage Owner')->get();
        $countries = country::all();
        $states = state::all();
        $cities = city::all();
        return view('garage-owners.index', compact('garageOwners', 'countries', 'states', 'cities'));
    }

    public function getData(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $garageOwners = User::where('user_type', 'Garage Owner')
        ->select('users.*')
        ->selectSub(function ($query) {
            $query->from('users as u')
                ->selectRaw('count(*)')
                ->whereColumn('u.garage_owner_id', 'users.id');
        }, 'garage_user_count')
        ->leftJoin('tbl_countries', 'users.country_id', '=', 'tbl_countries.id')
        ->addSelect('tbl_countries.name as country_name')
        ->orderBy('users.id', 'desc');

        //dd($garageOwners);


        return DataTables::of($garageOwners)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%")
                        ->orWhere('users.mobilenumber', 'like', "%{$search}%")
                        ->orWhere('users.zip', 'like', "%{$search}%")
                        ->orWhere('tbl_countries.name', 'like', "%{$search}%"); // Enable search by country
                    });
                }
            })
            ->addColumn('name', function ($owner) {
                return '<div class="position-relative ownerName">
                            <img src="'.asset('assets/images/users/avatar-1.jpg').'" alt="" class="avatar-xs rounded-circle me-2">
                            <span class="ownerNameCounter">' . ($owner->garage_users_count ?? $owner->garage_user_count ?? 0) . '</span>
                            <span class="text-body fw-medium">'.$owner->name.'</span>
                        </div>';
            })
            ->addColumn('country', function ($owner) {
                return $owner->country_name ?? 'N/A'; // Display country name or 'N/A' if null
            })
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
            ->addColumn('action', function ($owner) {
                return '
                    <button type="button" class="btn btn-soft-primary btn-border btn-icon shadow-none viewgarageownerdata" title="View" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInformation" aria-controls="offcanvasRight" data-id="'.$owner->id.'"><i class="ri-eye-line"></i></button>
                    <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none editgarageownerdata" title="Edit" data-bs-toggle="offcanvas" data-bs-target="#sidebarEditGarageOwner" aria-controls="offcanvasRight" data-id="'.$owner->id.'"><i class="ri-edit-line"></i></button>
                    <a href="'.route('garage.clients.page', $owner->id).'" class="btn btn-soft-secondary btn-border btn-icon shadow-none" title="Manage Client"><i class="ri-user-community-line"></i></a>
                    <a href="#" class="btn btn-soft-info btn-border btn-icon shadow-none" title="View Subscription History"><i class="ri-history-line"></i></a>
                    <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removeNotificationModal" title="Delete" data-bs-toggle="offcanvas" data-bs-target="#removeNotificationModal" aria-controls="offcanvasRight" data-id="'.$owner->id.'"><i class="ri-delete-bin-6-line"></i></button>
                ';
            })
            ->rawColumns(['name', 'action', 'status']) // Ensures HTML buttons render properly
            ->make(true);
    }   

    public function view(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->all(); // Get all input data
        $garageOwner = User::findOrFail($data['userId']);
        $profilepic = asset('assets/images/users/avatar-1.jpg');
        if($garageOwner["user_profile_pic"])
        {
            $profilepic = "";
        }
        $owner_data = array(
            "name"              =>  $garageOwner["name"],
            "email"             =>  $garageOwner["email"],
            "mobilenumber"      =>  $garageOwner["mobilenumber"],
            "dob"               =>  "N/A",
            "gender"            =>  "N/A",
            "address"           =>  $garageOwner["address"],
            "profilepic"        =>  $profilepic,
            "currentplan"       =>  "N/A",
            "connected_paypal"  =>  "N/A",
            "expirydate"        =>  "N/A",
        );
        return response()->json($owner_data);
    }

    public function editview(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->all(); // Get all input data
        $garageOwner = User::findOrFail($data['userId']);
        $owner_data = array(
            "id"                =>  $garageOwner["id"],
            "name"              =>  $garageOwner["name"],
            "email"             =>  $garageOwner["email"],
            "businessname"      =>  $garageOwner["businessname"],
            "mobilenumber"      =>  $garageOwner["mobilenumber"],
            "address"           =>  $garageOwner["address"],
            "country_id"        =>  $garageOwner["country_id"],
            "state_id"          =>  $garageOwner["state_id"],
            "city_id"           =>  $garageOwner["city_id"]
        );
        return response()->json($owner_data);
    }

    public function update(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $owner = User::find($request->id);
        if (!$owner) {
            return response()->json(['status' => 'error', 'message' => 'Owner not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'mobile' => 'required|digits_between:10,15',
            'country_id' => 'required|integer',
            'state_id' => 'required|integer',
            'city_id' => 'required|integer',
            'address' => 'required|string',
            'password' => 'nullable|min:6|same:confirm_password',
        ]);
    
        $owner = User::find($request->id);
        $owner->name = $request->name;
        $owner->businessname = $request->company_name;
        $owner->mobilenumber = $request->mobile;
        $owner->country_id = $request->country_id;
        $owner->state_id = $request->state_id;
        $owner->city_id = $request->city_id;
        $owner->address = $request->address;
    
        if ($request->password) {
            $owner->password = bcrypt($request->password);
        }
    
        $owner->save();
    
        return response()->json(['status' => 'success', 'message' => 'Garage owner updated successfully.']);
    }

    public function removedetails(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $owner = User::find($request->id);
        if (!$owner) {
            return response()->json(['status' => 'error', 'message' => 'Owner not found'], 404);
        }

        $owner->delete(); // now performs soft delete

        return response()->json(['status' => 'success', 'message' => 'Owner deleted successfully.']);
    }

    public function clientListPage($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $garageOwners = User::where('id', $id)
                     ->where('user_type', 'Garage Owner')
                     ->firstOrFail();
        return view('garage-owners.clients', compact('garageOwners'));
    }

    public function getClientData($id, Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

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
                '<a href="'.route('client.clientdetails', $user->id).'" class="btn btn-soft-primary btn-border btn-icon shadow-none"><i class="ri-eye-line"></i></a>
                <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none" title="Edit"><i class="ri-edit-line"></i></button>
                <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Delete"><i class="ri-delete-bin-6-line"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function clientdetails($id, Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $clientDetails = User::where('id', $id)
                     ->where('user_type', 'user')
                     ->firstOrFail();
        return view('garage-owners.clientdetails', compact('clientDetails'));
    }

}
