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

class SupplierController extends Controller
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
        $states = state::all();
        $cities = city::all();
        return view('garage-owner.supplier.list', compact('users', 'countries'));
    }

    public function getSupplierData(Request $request)
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

        $supplier = User::select('users.*')
                        ->selectRaw('(SELECT GROUP_CONCAT(product_name SEPARATOR ", ") 
                                    FROM tbl_products 
                                    WHERE tbl_products.product_supplier_id = users.id 
                                    AND tbl_products.product_garage_owner_id = '.$id.'
                                    AND tbl_products.deleted_at IS NULL) as product_names')
                        ->where('garage_owner_id', $id)
                        ->where('user_type', 'Supplier')
                        ->whereNull('deleted_at')
                        ->orderBy('id', 'desc');

        return DataTables::of($supplier)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('product_names', 'like', "%{$search}%")
                        ->orWhere('businessname', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('name', fn($supplier) => $supplier->name)
            ->addColumn('email', fn($supplier) => $supplier->email)
            ->addColumn('businessname', fn($supplier) => $supplier->businessname)
            ->addColumn('product_names', fn($supplier) => $supplier->product_names)
            ->addColumn('status', function ($supplier) {
                if( $supplier->user_status == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', fn($supplier) =>
                '<a href="#" title="View Supplier" class="btn btn-soft-primary btn-border btn-icon shadow-none viewsupplierinfo" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInformation" aria-controls="offcanvasRight" data-supplierid="'.$supplier->id.'"><i class="ri-eye-line"></i></a>
                <a href="#" title="Edit Supplier" class="btn btn-soft-success btn-border btn-icon shadow-none editviewsupplierdetails" data-bs-toggle="offcanvas" data-bs-target="#sidebarUpdateSupplier" aria-controls="offcanvasRight" data-supplierid="'.$supplier->id.'"><i class="ri-edit-line"></i></a>
                <button type="button" class="btn btn-soft-secondary btn-border btn-icon shadow-none" title="Reply/Email/Part Order"><i class="ri-reply-line"></i></button>
                <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removesupplierdetail" title="Archive" data-bs-toggle="offcanvas" data-bs-target="#removeSupplierNotificationModal" aria-controls="offcanvasRight" data-supplierid="'.$supplier->id.'"><i class="ri-archive-2-line"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function supplierDetail($id, Request $request)
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

        $garage_Owner = Auth::user();

        // Check if the user is a Garage Owner
        if ($garage_Owner->user_type !== 'Garage Owner') {
            abort(403, 'Unauthorized');
        }

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtsuppliername'           => 'required|string|max:100',
            'txtcompanyname'            => 'required|string|max:100',
            'txtsupplieremail'          => 'required|email|unique:users,email',
            'txtsuppliermobilenumber'   => 'required|string|max:15',
            'txtsupplierlandlinenumber' => 'nullable|string|max:15',
            'txtsuppliercountry'        => 'required|string|max:100',
            'txtsupplierstate'          => 'required|string|max:100',
            'txtsuppliercity'           => 'required|string|max:100',
            'txtsupplieraddress'        => 'required|string|max:255',
            'newsupplierphonecode'      => 'required|string|max:20',
            'newsupplierphoneicocode'   => 'required|string|max:20',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $supplier = new User();
        $supplier->name             = $request->txtsuppliername;
        $supplier->businessname     = $request->txtcompanyname;
        $supplier->email            = $request->txtsupplieremail;
        $supplier->user_type        = "Supplier";
        $supplier->countryisocode   = $request->newsupplierphoneicocode;
        $supplier->countrycode      = $request->newsupplierphonecode;
        $supplier->mobilenumber     = $request->txtsuppliermobilenumber;
        $supplier->country_id       = $request->txtsuppliercountry;
        $supplier->state_id         = $request->txtsupplierstate;
        $supplier->city_id          = $request->txtsuppliercity;
        $supplier->address          = $request->txtsupplieraddress;
        $supplier->garage_owner_id  = $garage_Owner->id;
        $supplier->user_status      = "1";

        if ($request->txtsupplierlandlinenumber) {
            $supplier->landlinenumber = $request->txtsupplierlandlinenumber;
        }        

        $supplier->save();
    
        return response()->json(['status' => 'success', 'message' => 'New Supplier data saved successfully.']);
    }

    public function supplierView(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->all(); // Get all input data
        $supplier = User::findOrFail($data['supplierId']);
        $supplier_data = array(
            "name"              =>  $supplier["name"],
            "email"             =>  $supplier["email"],
            "mobilenumber"      =>  $supplier["mobilenumber"],
            "address"           =>  $supplier["address"],
        );
        return response()->json($supplier_data);
    }

    public function editview(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = Auth::user();

        // Check if the user is a Garage Owner
        if ($user->user_type !== 'Garage Owner') {
            abort(403, 'Unauthorized');
        }

        $data = $request->all(); // Get all input data

        $supplierData = User::where('user_type', 'Supplier')->findOrFail($data['supplierId']);
        $states = state::where("country_id", $supplierData["country_id"])->get();
        $cities = city::where("state_id", $supplierData["state_id"])->get();

        $supplier_data = array(
            "id"                =>  $supplierData["id"],
            "name"              =>  $supplierData["name"],
            "email"             =>  $supplierData["email"],
            "businessname"      =>  $supplierData["businessname"],
            "countrycode"       =>  $supplierData["countrycode"],
            "countryisocode"    =>  $supplierData["countryisocode"],
            "mobilenumber"      =>  $supplierData["mobilenumber"],
            "landlinenumber"    =>  $supplierData["landlinenumber"],
            "address"           =>  $supplierData["address"],
            "country_id"        =>  $supplierData["country_id"],
            "state_id"          =>  $supplierData["state_id"],
            "city_id"           =>  $supplierData["city_id"],
            "states"            =>  $states,
            "cities"            =>  $cities,
        );
        return response()->json($supplier_data);
    }

    public function update(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $user = User::find($request->updatesupplierid);
        if (!$user) {
            return response()->json(['status' => 'error', 'message' => 'Supplier not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'txtupdatesuppliername'             => 'required|string|max:100',
            'txtupdatecompanyname'              => 'required|string|max:100',
            'txtupdatesupplieremail'            => 'required|email',
            'txtupdatesuppliermobilenumber'     => 'required|string|max:15',
            'txtupdatesupplierlandlinenumber'   => 'nullable|string|max:15',
            'txtupdatesuppliercountry'          => 'required|string|max:100',
            'txtupdatesupplierstate'            => 'required|string|max:100',
            'txtupdatesuppliercity'             => 'required|string|max:100',
            'txtupdatesupplieraddress'          => 'required|string|max:255',
            'updatesupplierphonecode'           => 'required|string|max:20',
            'updatesupplierphoneicocode'        => 'required|string|max:20',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $supplier = User::find($request->updatesupplierid);
        $supplier->name             = $request->txtupdatesuppliername;
        $supplier->businessname     = $request->txtupdatecompanyname;
        $supplier->email            = $request->txtupdatesupplieremail;
        $supplier->countryisocode   = $request->updatesupplierphoneicocode;
        $supplier->countrycode      = $request->updatesupplierphonecode;
        $supplier->mobilenumber     = $request->txtupdatesuppliermobilenumber;
        $supplier->country_id       = $request->txtupdatesuppliercountry;
        $supplier->state_id         = $request->txtupdatesupplierstate;
        $supplier->city_id          = $request->txtupdatesuppliercity;
        $supplier->address          = $request->txtupdatesupplieraddress;

        if ($request->txtupdatesupplierlandlinenumber) {
            $user->landlinenumber = $request->txtupdatesupplierlandlinenumber;
        }        

        $supplier->save();
    
        return response()->json(['status' => 'success', 'message' => 'Supplier detail updated successfully.']);
    }

    public function removedetails(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $garageOwner = Auth::user();

        if ($garageOwner->user_type !== 'Garage Owner') {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $supplier = User::where('garage_owner_id', $garageOwner->id)->find($request->id);
        if (!$supplier) {
            return response()->json(['status' => 'error', 'message' => 'Supplier not found'], 404);
        }

        $supplier->delete(); // now performs soft delete

        return response()->json(['status' => 'success', 'message' => 'Supplier archived successfully.']);
    }
}
