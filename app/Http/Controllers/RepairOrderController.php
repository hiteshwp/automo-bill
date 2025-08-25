<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Mail;
use Storage;

use Illuminate\Http\Request;
use App\Models\BookingModel;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\ProductModel;
use App\Models\EstimateModel;
use App\Models\EstimateLaborModel;
use App\Models\EstimatePartsModel;
use App\Models\RepairOrderModel;
use App\Models\InvoiceModel;
use App\Models\SettingModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class RepairOrderController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }
    }

    // For Garage Owenr data

    public function index($id)
    {
        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();
        $user_id = $user->id;

        $check_repair_order = RepairOrderModel::where('repairorder_estimate_id', $id)->first();
        if ($check_repair_order) {
            return redirect()->route('garage-owner.repair-order.edit', $check_repair_order->repairorder_id);
        }

        $estimate_data = EstimateModel::select('tbl_estimate.*', 'users.name as client_name', 'users.address as client_address', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle')
                        ->leftJoin('users', 'tbl_estimate.estimate_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_estimate.estimate_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_estimate.estimate_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->where('tbl_estimate.estimate_id', $id)
                        ->whereNull('tbl_estimate.deleted_at')
                        ->first();

        $labour_data = EstimateLaborModel::where("estimate_labor_estimate_id", $id)
                                        ->get();
        $total_hours = EstimateLaborModel::where("estimate_labor_estimate_id", $id)
                                        ->sum('estimate_labor_hours');

        $product_data = EstimatePartsModel::select("tbl_estimate_parts.estimate_parts_quantity", "tbl_products.product_name as product_name")
                                            ->leftJoin('tbl_products', 'tbl_products.product_id', '=', 'tbl_estimate_parts.estimate_parts_product_id')
                                            ->where("estimate_parts_estimate_id", $id)
                                            ->get();

        $setting_data = SettingModel::where("setting_garage_id", $user_id)->whereNull('deleted_at')->first();

        //echo '<pre>'; print_r($estimate_data); die;

        return view('garage-owner.repair-order.new', compact('estimate_data', 'labour_data', 'product_data', 'total_hours', 'setting_data'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtemployeename'       => 'required|string|max:250',
            'txtemployeeemail'      => 'required|string|max:250',
            'txtemployeephone'      => 'required|string|max:20',
            'txtrepairorderdate'    => 'required|string|max:20',
            'txtrepairorderstatus'  => 'required|string|max:10',
            'txtbookingid'          => 'required|string|max:10',
            'txtestimateid'         => 'required|string|max:10',
            'txtgarageid'           => 'required|string|max:10',
            'txtcustomerid'         => 'required|string|max:10',
            'txtvehicleid'          => 'required|string|max:10',
            'txtextranotes'         => 'required|string|max:500',
            'txttotalparts'         => 'required|string|max:30',
            'txttotalamount'        => 'required|string|max:30',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            // Store booking record
            $repairOrder = new RepairOrderModel();
            $repairOrder->repairorder_booking_id        = $request->txtbookingid;
            $repairOrder->repairorder_estimate_id       = $request->txtestimateid;
            $repairOrder->repairorder_garage_id         = $garage_Owner->id;
            $repairOrder->repairorder_customer_id       = $request->txtcustomerid;
            $repairOrder->repairorder_vehicle_id        = $request->txtvehicleid;
            $repairOrder->repairorder_order_date        = $request->txtrepairorderdate;
            $repairOrder->repairorder_notes             = $request->txtextranotes;
            $repairOrder->repairorder_labor_total       = $request->txttotalamount;
            $repairOrder->repairorder_parts_total       = $request->txttotalparts;
            $repairOrder->repairorder_order_no          = $this->generateUniqueRepairOrderNumber();  
            $repairOrder->repairorder_garage_employee   = $request->txtemployeename;  
            $repairOrder->repairorder_employee_email    = $request->txtemployeeemail;  
            $repairOrder->repairorder_employee_phone    = $request->txtemployeephone;  
            $repairOrder->repairorder_amount            = $request->txttotalamount;  
            $repairOrder->repairorder_status            = "1";  
            
            // if( $request->txtbookingservice )
            // {
            //     $repairOrder->booking_is_service = "1";
            // }
            

            $repairOrder->save();

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'New Repair Order data saved successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // ❌ Rollback on error

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong while saving data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function list()
    {
        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();
        $user_id = $user->id;

        $repair_order_data = RepairOrderModel::whereNull('tbl_repair_order.deleted_at')
                                                ->get();

        return view('garage-owner.repair-order.list', compact('repair_order_data'));
    }

    public function getRepairOrderData(Request $request)
    {
        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();

        $user_id = $user->id;

        $repair_order = RepairOrderModel::select('tbl_repair_order.*', 'users.name as client_name', 'tbl_vehicles.number_plate as number_plate', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle')
                        ->leftJoin('users', 'tbl_repair_order.repairorder_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_repair_order.repairorder_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_repair_order.repairorder_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->whereNull('tbl_repair_order.deleted_at')
                        ->orderBy('tbl_repair_order.repairorder_id', 'desc');

        return DataTables::of($repair_order)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('repairorder_estimate_id', 'like', "%{$search}%")
                        ->orWhere('repairorder_order_no', 'like', "%{$search}%")
                        ->orWhere('repairorder_garage_employee', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%")
                        ->orWhere('number_plate', 'like', "%{$search}%")
                        ->orWhere('vehicle', 'like', "%{$search}%")
                        ->orWhere('vin', 'like', "%{$search}%")
                        ->orWhere('repairorder_amount', 'like', "%{$search}%")
                        ->orWhere('repairorder_order_date', 'like', "%{$search}%")
                        ->orWhere('repairorder_status', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('repairorder_estimate_id', fn($repair_order) => $repair_order->repairorder_estimate_id)
            ->addColumn('repairorder_order_no', fn($repair_order) => $repair_order->repairorder_order_no)
            ->addColumn('repairorder_garage_employee', fn($repair_order) => $repair_order->repairorder_garage_employee)
            ->addColumn('client_name', fn($repair_order) => $repair_order->client_name)
            ->addColumn('number_plate', fn($repair_order) => $repair_order->number_plate)
            ->addColumn('vehicle', content: fn($repair_order) => $repair_order->vehicle)
            ->addColumn('vin', fn($repair_order) => $repair_order->vin)
            ->addColumn('repairorder_amount', fn($repair_order) => $repair_order->repairorder_amount)
            ->addColumn('repairorder_order_date', fn($repair_order) => date("Y-m-d", strtotime($repair_order->repairorder_order_date)))
            ->addColumn('repaiorder_clock_in', fn($repair_order) =>
                '<div class="start-end-timer-block">
                    <a href="javascript:;" class="badge bg-success-subtle text-success" title="Clock In">
                        <span class="timer-title" style="display: block;"><i class="ri-time-line"></i> Start Timer</span>
                        <span class="timer-count" style="display: none;"><i class="ri-time-line"></i> 03/01/2025 - 02:57:38 PM</span>
                    </a>
                </div>'
            )
            ->addColumn('repaiorder_clock_out', fn($repair_order) =>
                '<div class="start-end-timer-block">
                    <a href="javascript:;" class="badge bg-danger-subtle text-danger" title="Clock Out">
                        <span class="timer-title" style="display: block;"><i class="ri-time-line"></i> End Timer</span>
                        <span class="timer-count" style="display: none;"><i class="ri-time-line"></i> 03/01/2025 - 02:57:38 PM</span>
                    </a>
                </div>'
            )
            ->addColumn('repairorder_status', function ($repair_order) {
                if( $repair_order->repairorder_status == "1" )
                {
                    return '<span class="text-warning">Pending</span>';
                }
                else if( $repair_order->repairorder_status == "2" )
                {
                    return '<span class="text-success">Done</span>';
                }
                else if( $repair_order->repairorder_status == "3" )
                {
                    return '<span class="text-primary">Not Done</span>';
                }
                else
                {
                    return '<span class="text-info">Update Estimation Again Request!</span>';
                }
            })
            ->addColumn('action', function ($repair_order) {

                if( $repair_order->repairorder_status == "2" )
                {
                    return '<a href="javascript:void(0);" class="btn btn-soft-success btn-border btn-icon shadow-none btn-select3 disabled" title="Edit"><i class="ri-edit-line"></i></a>
                            <a href="javascript:void(0);" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="View TimeLog" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewTimeLog" aria-controls="offcanvasRight"><i class="ri-time-line"></i></a>
                            <a href="'.route('garage-owner.invoice.new', $repair_order->repairorder_id).'" class="btn btn-soft-info btn-border btn-icon shadow-none" title="One Click Invoice"><i class="ri-file-paper-2-line"></i></a>
                            <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none disabled" title="Archive"><i class="ri-archive-2-line"></i></button>';
                }
                else
                {   
                    return '<a href="'.route('garage-owner.repair-order.edit', $repair_order->repairorder_id).'" class="btn btn-soft-success btn-border btn-icon shadow-none btn-select3" title="Edit"><i class="ri-edit-line"></i></a>
                            <a href="javascript:void(0);" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="View TimeLog" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewTimeLog" aria-controls="offcanvasRight"><i class="ri-time-line"></i></a>
                            <a href="" class="btn btn-soft-info btn-border btn-icon shadow-none disabled" title="One Click Invoice"><i class="ri-file-paper-2-line"></i></a>
                            <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Archive"><i class="ri-archive-2-line"></i></button>';
                }
            })
            ->rawColumns(['repaiorder_clock_in', 'repaiorder_clock_out', 'repairorder_status', 'action'])
            ->make(true);
    }

    function generateUniqueRepairOrderNumber()
    {
        do {
            $number = 'RO' . random_int(100000, 999999); // Generates like PR659808
        } while (ProductModel::where('product_number', $number)->exists());

        return $number;
    }

    public function edit($id)
    {
        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();
        $user_id = $user->id;

        $repair_order_data = RepairOrderModel::select('tbl_repair_order.*', 'users.name as client_name', 'users.address as client_address', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle', 'tbl_estimate.estimate_labor_total', 'tbl_estimate.estimate_parts_total', 'tbl_estimate.estimate_tax', 'tbl_estimate.estimate_total_inctax', 'tbl_estimate.estimate_total')
                        ->leftJoin('users', 'tbl_repair_order.repairorder_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_repair_order.repairorder_vehicle_id', '=', 'tbl_vehicles.id')
                        ->leftJoin('tbl_estimate', 'tbl_repair_order.repairorder_estimate_id', '=', 'tbl_estimate.estimate_id')
                        ->where('tbl_repair_order.repairorder_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->where('tbl_repair_order.repairorder_id', $id)
                        ->whereNull('tbl_repair_order.deleted_at')
                        ->first();

        //echo "<pre>"; print_r($repair_order_data); die;

        $labour_data = EstimateLaborModel::where("estimate_labor_estimate_id", $repair_order_data->repairorder_estimate_id)
                                            ->where("estimate_labor_reference_type", "1")
                                            ->get();
        //echo "<pre>"; print_r($labour_data); die;

        $product_data = EstimatePartsModel::select("tbl_estimate_parts.*", "tbl_products.product_name as product_name")
                                            ->leftJoin('tbl_products', 'tbl_products.product_id', '=', 'tbl_estimate_parts.estimate_parts_product_id')
                                            ->where("estimate_parts_estimate_id", $repair_order_data->repairorder_estimate_id)
                                            ->where("estimate_parts_reference_type", "1")
                                            ->get();

        $total_hours = EstimateLaborModel::where("estimate_labor_estimate_id", $id)
                                        ->sum('estimate_labor_hours');

        $setting_data = SettingModel::where("setting_garage_id", $user_id)->whereNull('deleted_at')->first();

        return view('garage-owner.repair-order.edit', compact('repair_order_data', 'labour_data', 'product_data', 'total_hours', 'setting_data'));
    }

    public function update(Request $request)
    {
        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtemployeename'       => 'required|string|max:250',
            'txtemployeeemail'      => 'required|string|max:250',
            'txtemployeephone'      => 'required|string|max:20',
            'txtrepairorderdate'    => 'required|string|max:20',
            'txtrepairorderstatus'  => 'required|string|max:10',
            'txtbookingid'          => 'required|string|max:10',
            'txtestimateid'         => 'required|string|max:10',
            'txtgarageid'           => 'required|string|max:10',
            'txtcustomerid'         => 'required|string|max:10',
            'txtvehicleid'          => 'required|string|max:10',
            'txtextranotes'         => 'nullable',
            'txttotalparts'         => 'required|string|max:30',
            'txttotalamount'        => 'required|string|max:30',
            'txtrepairorderid'      => 'required|string|max:30',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            
            $updateRepairOrder = RepairOrderModel::where('repairorder_garage_id', $garage_Owner->id)
                                            ->where('repairorder_id', $request->txtrepairorderid)
                                            ->firstOrFail();

            // Store booking record
            $updateRepairOrder->repairorder_booking_id        = $request->txtbookingid;
            $updateRepairOrder->repairorder_estimate_id       = $request->txtestimateid;
            $updateRepairOrder->repairorder_garage_id         = $garage_Owner->id;
            $updateRepairOrder->repairorder_customer_id       = $request->txtcustomerid;
            $updateRepairOrder->repairorder_vehicle_id        = $request->txtvehicleid;
            $updateRepairOrder->repairorder_order_date        = $request->txtrepairorderdate;
            $updateRepairOrder->repairorder_notes             = $request->txtextranotes;
            $updateRepairOrder->repairorder_labor_total       = $request->txttotalamount;
            $updateRepairOrder->repairorder_parts_total       = $request->txttotalparts;  
            $updateRepairOrder->repairorder_garage_employee   = $request->txtemployeename;  
            $updateRepairOrder->repairorder_employee_email    = $request->txtemployeeemail;  
            $updateRepairOrder->repairorder_employee_phone    = $request->txtemployeephone;  
            $updateRepairOrder->repairorder_amount            = $request->txtrepairorderstatus;  
            $updateRepairOrder->repairorder_status            = $request->txtrepairorderstatus;  
            
            // if( $request->txtbookingservice )
            // {
            //     $repairOrder->booking_is_service = "1";
            // }
            

            $updateRepairOrder->save();

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'Repair Order data Updated successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // ❌ Rollback on error

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong while saving data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // End

    // #################################################################################################### //

    // For User data

    public function clientRepairOrderData()
    {
        if (Auth::user()->user_type !== 'User') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();
        $user_id = $user->id;

        $repair_order_data = RepairOrderModel::whereNull('deleted_at')
                                                ->get();

        return view('user.repair-order.list', compact('repair_order_data'));
    }

    public function getClientRepairOrderData(Request $request)
    {
        if (Auth::user()->user_type !== 'User') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();
        $user_id = $user->id;

        $repair_order = RepairOrderModel::select('tbl_repair_order.*', 'users.name as garage_owner_name', 'tbl_vehicles.number_plate as number_plate', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle')
                        ->leftJoin('users', 'tbl_repair_order.repairorder_garage_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_repair_order.repairorder_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_repair_order.repairorder_customer_id', $user_id)
                        ->where('users.user_type', 'Garage Owner')
                        ->whereNull('tbl_repair_order.deleted_at')
                        ->orderBy('tbl_repair_order.repairorder_id', 'desc');

        return DataTables::of($repair_order)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('repairorder_estimate_id', 'like', "%{$search}%")
                        ->orWhere('repairorder_order_no', 'like', "%{$search}%")
                        ->orWhere('repairorder_garage_employee', 'like', "%{$search}%")
                        ->orWhere('garage_owner_name', 'like', "%{$search}%")
                        ->orWhere('number_plate', 'like', "%{$search}%")
                        ->orWhere('vehicle', 'like', "%{$search}%")
                        ->orWhere('vin', 'like', "%{$search}%")
                        ->orWhere('repairorder_amount', 'like', "%{$search}%")
                        ->orWhere('repairorder_order_date', 'like', "%{$search}%")
                        ->orWhere('repairorder_status', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('repairorder_estimate_id', fn($repair_order) => $repair_order->repairorder_estimate_id)
            ->addColumn('repairorder_order_no', fn($repair_order) => $repair_order->repairorder_order_no)
            ->addColumn('repairorder_garage_employee', fn($repair_order) => $repair_order->repairorder_garage_employee)
            ->addColumn('garage_owner_name', fn($repair_order) => $repair_order->garage_owner_name)
            ->addColumn('number_plate', fn($repair_order) => $repair_order->number_plate)
            ->addColumn('vehicle', content: fn($repair_order) => $repair_order->vehicle)
            ->addColumn('vin', fn($repair_order) => $repair_order->vin)
            ->addColumn('repairorder_amount', fn($repair_order) => $repair_order->repairorder_amount)
            ->addColumn('repairorder_order_date', fn($repair_order) => date("Y-m-d", strtotime($repair_order->repairorder_order_date)))
            ->addColumn('repaiorder_clock_in', fn($repair_order) =>
                '<div class="start-end-timer-block">
                    <a href="javascript:;" class="badge bg-success-subtle text-success" title="Clock In">
                        <span class="timer-title" style="display: block;"><i class="ri-time-line"></i> Start Timer</span>
                        <span class="timer-count" style="display: none;"><i class="ri-time-line"></i> 03/01/2025 - 02:57:38 PM</span>
                    </a>
                </div>'
            )
            ->addColumn('repaiorder_clock_out', fn($repair_order) =>
                '<div class="start-end-timer-block">
                    <a href="javascript:;" class="badge bg-danger-subtle text-danger" title="Clock Out">
                        <span class="timer-title" style="display: block;"><i class="ri-time-line"></i> End Timer</span>
                        <span class="timer-count" style="display: none;"><i class="ri-time-line"></i> 03/01/2025 - 02:57:38 PM</span>
                    </a>
                </div>'
            )
            ->addColumn('repairorder_status', function ($repair_order) {
                if( $repair_order->repairorder_status == "1" )
                {
                    return '<span class="text-warning">Pending</span>';
                }
                else if( $repair_order->repairorder_status == "2" )
                {
                    return '<span class="text-success">Done</span>';
                }
                else if( $repair_order->repairorder_status == "3" )
                {
                    return '<span class="text-primary">Not Done</span>';
                }
                else
                {
                    return '<span class="text-info">Update Estimation Again Request!</span>';
                }
            })
            ->addColumn('action', function ($repair_order) {

                if( $repair_order->repairorder_status == "2" )
                {
                    return '<a href="javascript:void(0);" class="btn btn-soft-success btn-border btn-icon shadow-none disabled" title="Approved Repair Order"><i class="ri-thumb-up-line"></i></a>
                            <a href="javascript:void(0);" class="btn btn-soft-danger btn-border btn-icon shadow-none disabled" title="Rejected Repair Order"><i class="ri-thumb-down-line"></i></a>
                            <a href="javascript:void(0);" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="View TimeLog" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewTimeLog" aria-controls="offcanvasRight"><i class="ri-time-line"></i></a>';
                }
                else
                {   
                    return '<a href="javascript:void(0);" class="btn btn-soft-success btn-border btn-icon shadow-none updateRepairOrderStatusModal" data-repairorder-type="Done" data-repairorder-id="'.$repair_order->repairorder_id.'" data-btncolor="btn w-sm btn-success" title="Done Repair Order" data-bs-toggle="offcanvas" data-bs-target="#updateRepairOrderStatusModal" aria-controls="offcanvasRight"><i class="ri-thumb-up-line"></i></a>
                            <a href="javascript:void(0);" class="btn btn-soft-danger btn-border btn-icon shadow-none updateRepairOrderStatusModal" data-repairorder-type="Not Done" data-repairorder-id="'.$repair_order->repairorder_id.'" data-btncolor="btn w-sm btn-danger" title="Not Done Repair Order" data-bs-toggle="offcanvas" data-bs-target="#updateRepairOrderStatusModal" aria-controls="offcanvasRight"><i class="ri-thumb-down-line"></i></a>
                            <a href="javascript:void(0);" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="View TimeLog" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewTimeLog" aria-controls="offcanvasRight"><i class="ri-time-line"></i></a>';
                }
            })
            ->rawColumns(['repaiorder_clock_in', 'repaiorder_clock_out', 'repairorder_status', 'action'])
            ->make(true);
    }

    public function updatRepairOrderStatus(Request $request)
    {
        if (Auth::user()->user_type !== 'User') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();
        $user_id = $user->id;

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'repairorderId'               => 'required|string|max:30',
            'repairorderType'             => 'required|string|max:50'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {

             $updateRepairOrder = RepairOrderModel::where('repairorder_id', $request->repairorderId)
                                            ->firstOrFail();

            $status_arr = array(
                "Done" => "2",
                "Not Done"  => "3"
            );

            $updateRepairOrder->repairorder_status  =   $status_arr[$request->repairorderType];
            $updateRepairOrder->save();

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'Repair Order '.strtoupper($request->repairorderType).' successfully.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // ❌ Rollback on error

            return response()->json([
                'status'  => 'error',
                'message' => 'Something went wrong while saving data.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // End
}
