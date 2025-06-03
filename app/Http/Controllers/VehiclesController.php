<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Mail;
use Storage;

use Illuminate\Http\Request;
use App\Models\user;
use App\Models\Vehicle;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class VehiclesController extends Controller
{

    public function index($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Get logged-in user
        $clients = Auth::user();

        // Check if the user is a Garage Owner
        if ($clients->user_type !== 'Garage Owner') {
            abort(403, 'Unauthorized');
        }

        $client_details = User::where('id', $id)
                                ->where('user_type', 'User')
                                ->firstOrFail();

        $years = [];
        $current_year = date("Y");
        for ($i = $current_year; $i >= 1980; $i--) 
        {
            $years[] = $i;
        }

        return view('garage-owner.vehicles.index', compact('client_details', 'years'));
    }
    public function getClientsVehicleData(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $User = Auth::user();

        if ($User->user_type !== 'Garage Owner') {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $current_customer_id = $request->input('customer_id');

        $vehicles = Vehicle::where('customer_id', $current_customer_id)
                            ->where('garage_id', $User->id)
                            ->select('tbl_vehicles.*')
                            ->orderBy('tbl_vehicles.id', 'desc');

        //dd($garageOwners);


        return DataTables::of($vehicles)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('tbl_vehicles.vin', 'like', "%{$search}%")
                        ->orWhere('tbl_vehicles.chassisno', 'like', "%{$search}%")
                        ->orWhere('tbl_vehicles.number_plate', 'like', "%{$search}%")
                        ->orWhere('tbl_vehicles.modelyear', 'like', "%{$search}%")
                        ->orWhere('tbl_vehicles.modelname', 'like', "%{$search}%")
                        ->orWhere('tbl_vehicles.modelbrand', 'like', "%{$search}%"); // Enable search by country
                    });
                }
            })
            ->addColumn('vehicle_status', function ($vehicles) {
                if( $vehicles->vehicle_status == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', function ($vehicles) {
                return '
                    <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none editviewvehicledetails" title="Edit" data-bs-toggle="offcanvas" data-bs-target="#sidebarEditVehicle" aria-controls="offcanvasRight" data-id="'.$vehicles->id.'"><i class="ri-edit-line"></i></button>
                    <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removeVehicleNotificationModal" title="Delete" data-bs-toggle="offcanvas" data-bs-target="#removeVechicleNotificationModal" aria-controls="offcanvasRight" data-id="'.$vehicles->id.'"><i class="ri-delete-bin-6-line"></i></button>
                ';
            })
            ->rawColumns(['action', 'vehicle_status']) // Ensures HTML buttons render properly
            ->make(true);        
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $User = Auth::user();

        if ($User->user_type !== 'Garage Owner') {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $validator = Validator::make($request->all(), [
            'vindetails'            => 'required|string|max:100',
            'vehiclelicenceplate'   => 'required|string|unique:tbl_vehicles,vin',
            'vehiclemake'           => 'required|string|max:100',
            'vehiclemodel'          => 'required|string|max:100',
            'vehiclemakeyear'       => 'required|string|max:100',
            'vehiclelastservicedate'=> 'required|string|max:100',
            'vehiclecustomerid'     => 'required|string|max:100',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $Vehicle = new Vehicle();
        $Vehicle->vin               = $request->vindetails;
        $Vehicle->number_plate      = $request->vehiclelicenceplate;
        $Vehicle->modelbrand        = $request->vehiclemake;
        $Vehicle->modelname         = $request->vehiclemodel;
        $Vehicle->modelyear         = $request->vehiclemakeyear;
        $Vehicle->lastservice       = $request->vehiclelastservicedate;
        $Vehicle->customer_id       = $request->vehiclecustomerid;
        $Vehicle->garage_id         = $User->id;
        $Vehicle->vehicle_status    = "1";        

        $Vehicle->save();
    
        return response()->json(['status' => 'success', 'message' => 'New Vehicle data saved successfully.']);
    }

    public function view(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $User = Auth::user();

        if ($User->user_type !== 'Garage Owner') {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $data = $request->all(); // Get all input data
        $vehicleData = Vehicle::where('garage_id', $User->id)
                                ->findOrFail($data['vehicleId']);

        $vehicle_data = array(
            "id"            =>  $vehicleData["id"],
            "vin"           =>  $vehicleData["vin"],
            "number_plate"  =>  $vehicleData["number_plate"],
            "modelyear"     =>  $vehicleData["modelyear"],
            "modelname"     =>  $vehicleData["modelname"],
            "modelbrand"    =>  $vehicleData["modelbrand"],
            "lastservice"   =>  $vehicleData["lastservice"],
        );
        return response()->json($vehicle_data);
    }

    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $User = Auth::user();

        if ($User->user_type !== 'Garage Owner') {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $Vehicles = Vehicle::find($request->txtupdatevehicleid);
        if (!$Vehicles) {
            return response()->json(['status' => 'error', 'message' => 'Vehicle not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'txtupdatevehiclevindetails'        => 'required|string|max:100',
            'txtupdatevehiclelicenceplate'      => 'required|string|max:100',
            'txtupdatevehiclemake'              => 'required|string|max:100',
            'txtupdatevehiclemodel'             => 'required|string|max:100',
            'txtupdatevehiclemakeyear'          => 'required|string|max:100',
            'txtupdatevehiclelastservicedate'   => 'required|string|max:100',
            'txtupdatevehicleid'                => 'required|string|max:100',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $Vehicles = Vehicle::find($request->txtupdatevehicleid);
        $Vehicles->vin               = $request->txtupdatevehiclevindetails;
        $Vehicles->number_plate      = $request->txtupdatevehiclelicenceplate;
        $Vehicles->modelbrand        = $request->txtupdatevehiclemake;
        $Vehicles->modelname         = $request->txtupdatevehiclemodel;
        $Vehicles->modelyear         = $request->txtupdatevehiclemakeyear;
        $Vehicles->lastservice       = $request->txtupdatevehiclelastservicedate;

        $Vehicles->save();
    
        return response()->json(['status' => 'success', 'message' => 'Vehicle updated successfully.']);
    }

    public function removedetails(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $User = Auth::user();

        if ($User->user_type !== 'Garage Owner') {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        $vehicle = vehicle::where('garage_id', $User->id)->find($request->id);
        if (!$vehicle) {
            return response()->json(['status' => 'error', 'message' => 'Vehicle not found'], 404);
        }

        $vehicle->delete(); // now performs soft delete

        return response()->json(['status' => 'success', 'message' => 'Vehicle deleted successfully.']);
    }
}
