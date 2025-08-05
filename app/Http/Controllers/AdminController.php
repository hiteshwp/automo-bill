<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get logged-in user
        $user = Auth::user();

        // Check if the user is a Admin
        if ($user->user_type !== 'Super Admin') {
            abort(403, 'Unauthorized');
        }

        $user_id = $user->id;

        $adminList = User::where('user_type', 'Admin')->get();
        $countries = Country::all();
        $states = State::all();
        $cities = City::all();
        return view('admin.admin.index', compact('adminList', 'countries', 'states', 'cities'));
    }

    public function getData(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $garageOwners = User::where('user_type', 'Admin')
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
                        ->orWhere('users.mobilenumber', 'like', "%{$search}%"); // Enable search by country
                    });
                }
            })
            ->addColumn('name', function ($admin) {
                $image = asset('assets/images/users/avatar-1.jpg');
                if( $admin->user_profile_pic != "" )
                {
                    $image = asset('uploads/profiles/'.$admin->user_profile_pic);
                }
                return '<div class="position-relative ownerName">
                            <img src="'.$image.'" alt="" class="avatar-xs rounded-circle me-2">
                            <span class="text-body fw-medium">'.ucwords($admin->name).'</span>
                        </div>';
            })
            ->addColumn('country', function ($admin) {
                return $admin->country_name ?? 'N/A'; // Display country name or 'N/A' if null
            })
            ->addColumn('status', function ($admin) {
                if( $admin->user_status == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', function ($admin) {
                return '
                    <button type="button" class="btn btn-soft-primary btn-border btn-icon shadow-none viewadmindetailonpopup" title="View" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInformation" aria-controls="offcanvasRight" data-id="'.$admin->id.'"><i class="ri-eye-line"></i></button>
                    <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none sidebarUpdateAdmin" title="Edit" data-bs-toggle="offcanvas" data-bs-target="#sidebarUpdateAdmin" aria-controls="offcanvasRight" data-id="'.$admin->id.'"><i class="ri-edit-line"></i></button>
                    <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removeAdminNotificationModal" title="Delete" data-bs-toggle="offcanvas" data-bs-target="#removeAdminNotificationModal" aria-controls="offcanvasRight" data-id="'.$admin->id.'"><i class="ri-delete-bin-6-line"></i></button>
                ';
            })
            ->rawColumns(['name', 'action', 'status']) // Ensures HTML buttons render properly
            ->make(true);
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }


        $validator = Validator::make($request->all(), [
            'newadminfullname'          => 'required|string|max:100',
            'newadminemail'             => 'required|email|unique:users,email',
            'newadminpassword'          => 'required|min:6',
            'newadminconfirmpassword'   => 'required|min:6',
            'newadminphone'             => 'required',
            'newadmineditcountry'       => 'required|string|max:100',
            'newadmineditstate'         => 'required|string|max:100',
            'newadmineditcity'          => 'required|string|max:100',
            'newadminaddress'           => 'required|string|max:255',
            'newadminphonecode'         => 'required|string|max:255',
            'newadminphoneicocode'      => 'required|string|max:255',
            'filepond'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $user = new User();
        $user->name             = $request->newadminfullname;
        $user->email            = $request->newadminemail;
        $user->user_type        = "Admin";
        $user->password         = Hash::make($request->newadminpassword);
        $user->mobilenumber     = $request->newadminphone;
        $user->country_id       = $request->newadmineditcountry;
        $user->state_id         = $request->newadmineditstate;
        $user->city_id          = $request->newadmineditcity;
        $user->address          = $request->newadminaddress;
        $user->countryisocode   = $request->newadminphoneicocode;
        $user->countrycode      = $request->newadminphonecode;
        $user->user_status      = "1";

        if ($request->newadminjoindate) {
            $user->user_join_date = $request->newadminjoindate;
        }
        
        if ($request->newadminleftdate) {
            $user->user_left_date = $request->newadminleftdate;
        }
    
        if ($request->hasFile('filepond')) {
            $file = $request->file('filepond');
            $filename = date("YmdHis") . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles/'), $filename);
            $user->user_profile_pic = $filename;
        } else {
            $user->user_profile_pic = 'avtar.png';
        }
        

        $user->save();
    
        return response()->json(['status' => 'success', 'message' => 'New Admin data saved successfully.']);
    }

    public function view(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->all(); // Get all input data
        $adminUser = User::where("user_type", "Admin")->findOrFail($data['userId']);
        $profilepic = asset('assets/images/users/avatar-1.jpg');
        $joindate = "N/A";
        if($adminUser["user_profile_pic"] != "")
        {
            $profilepic = asset('uploads/profiles/'.$adminUser["user_profile_pic"]);
        }
        if($adminUser["user_join_date"] != "")
        {
            $joindate = $adminUser["user_join_date"];
        }
        $owner_data = array(
            "name"              =>  $adminUser["name"],
            "email"             =>  $adminUser["email"],
            "mobilenumber"      =>  $adminUser["mobilenumber"],
            "address"           =>  $adminUser["address"],
            "profilepic"        =>  $profilepic,
            "joindate"          =>  $joindate,
        );
        return response()->json($owner_data);
    }

    public function removedetails(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $admin = User::where("user_type", "Admin")->find($request->id);
        if (!$admin) {
            return response()->json(['status' => 'error', 'message' => 'Admin Detail not found'], 404);
        }

        $admin->delete(); // now performs soft delete

        return response()->json(['status' => 'success', 'message' => 'Admin Detail deleted successfully.']);
    }

    public function editview(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->all(); // Get all input data
        $adminUser = User::where("user_type", "Admin")->findOrFail($data['userId']);
        $states = State::where("country_id", $adminUser["country_id"])->get();
        $cities = City::where("state_id", $adminUser["state_id"])->get();

        $profilepic = asset('assets/images/users/avatar-1.jpg');
        if($adminUser["user_profile_pic"] != "")
        {
            $profilepic = asset('uploads/profiles/'.$adminUser["user_profile_pic"]);
        }

        $owner_data = array(
            "id"                =>  $adminUser["id"],
            "name"              =>  $adminUser["name"],
            "email"             =>  $adminUser["email"],
            "mobilenumber"      =>  $adminUser["mobilenumber"],
            "address"           =>  $adminUser["address"],
            "country_id"        =>  $adminUser["country_id"],
            "state_id"          =>  $adminUser["state_id"],
            "city_id"           =>  $adminUser["city_id"],
            "countrycode"       =>  $adminUser["countrycode"],
            "countryisocode"    =>  $adminUser["countryisocode"],
            "user_join_date"    =>  $adminUser["user_join_date"],
            "user_left_date"    =>  $adminUser["user_left_date"],
            "states"            =>  $states,
            "cities"            =>  $cities,
            "user_profile_pic"  =>  $profilepic,
        );
        return response()->json($owner_data);
    }

    public function update(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $adminUser = User::where("user_type", "Admin")->find($request->updateadminid);
        if (!$adminUser) {
            return response()->json(['status' => 'error', 'message' => 'Owner not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'updateadminfullname'           => 'required|string|max:100',
            'updateadminpassword'           => 'nullable|min:6',
            'updateadminconfirmpassword'    => 'nullable|min:6',
            'updateadminphone'              => 'required',
            'updateadmineditcountry'        => 'required|string|max:100',
            'updateadmineditstate'          => 'required|string|max:100',
            'updateadmineditcity'           => 'required|string|max:100',
            'updateadminaddress'            => 'required|string|max:255',
            'updateadminphonecode'          => 'required|string|max:20',
            'updateadminphoneicocode'       => 'required|string|max:20',
            'editfilepond'                  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $adminUser->name            = $request->updateadminfullname;
        $adminUser->mobilenumber    = $request->updateadminphone;
        $adminUser->country_id      = $request->updateadmineditcountry;
        $adminUser->state_id        = $request->updateadmineditstate;
        $adminUser->city_id         = $request->updateadmineditcity;
        $adminUser->address         = $request->updateadminaddress;
        $adminUser->countryisocode  = $request->updateadminphoneicocode;
        $adminUser->countrycode     = $request->updateadminphonecode;

        if ($request->updateadminjoindate) {
            $adminUser->user_join_date = $request->updateadminjoindate;
        }
        
        if ($request->updateadminleftdate) {
            $adminUser->user_left_date = $request->updateadminleftdate;
        }
    
        if ($request->updateadminpassword) {
            $adminUser->password = Hash::make($request->updateadminpassword);
        }

        if ($request->hasFile('editfilepond')) {
            $file = $request->file('editfilepond');
            $filename = date("YmdHis") . '-' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profiles/'), $filename);
            $adminUser->user_profile_pic = $filename;
        }
    
        $adminUser->save();
    
        return response()->json(['status' => 'success', 'message' => 'Admin detail updated successfully.']);
    }
}
