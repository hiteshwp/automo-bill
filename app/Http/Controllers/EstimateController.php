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
use App\Models\SettingModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class EstimateController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }
    }
    public function index($id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $check_estimate = EstimateModel::where('estimate_booking_id', $id)->first();
        if ($check_estimate) {
            return redirect()->route('garage-owner.estimate.edit', $check_estimate->estimate_id);
        }

        $booking_data = BookingModel::select('tbl_booking.*', 'users.name as client_name', 'users.address as client_address', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle')
                        ->leftJoin('users', 'tbl_booking.booking_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_booking.booking_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_booking.booking_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->where('tbl_booking.booking_id', $id)
                        ->whereNull('tbl_booking.deleted_at')
                        ->first();

        $product_list = ProductModel::where('product_garage_owner_id', $user_id)
                                    ->orderBy('product_name', 'asc')
                                    ->get();

        $setting_data = SettingModel::where("setting_garage_id", $user_id)->whereNull('deleted_at')->first();

        return view('garage-owner.estimate.new', compact('booking_data', 'product_list', 'setting_data'));
    }

    public function store(Request $request)
    {
        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtestimatedate'               => 'required|string|max:30',
            'txtsumtotallabour'             => 'required|string|max:50',
            'txtsumtotalparts'              => 'required|string|max:50',
            'txtsumtotaltax'                => 'required|string|max:50',
            'txtsumtotaldueamountexcepttax' => 'required|string|max:50',
            'txtsumtotaldueamount'          => 'required|string|max:50',
            'txtbookingid'                  => 'required|string|max:50',
            'txtcustomerid'                 => 'required|string|max:50',
            'txtvehicleid'                  => 'required|string|max:50'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            // Store booking record
            $estimate = new EstimateModel();
            $estimate->estimate_booking_id          =   $request->txtbookingid;
            $estimate->estimate_estimate_no         =   $this->generateUniqueEsimateNumber();;
            $estimate->estimate_garage_id           =   $garage_Owner->id;
            $estimate->estimate_customer_id         =   $request->txtcustomerid;
            $estimate->estimate_vehicle_id          =   $request->txtvehicleid;
            $estimate->estimate_date                =   date("Y-m-d", strtotime($request->txtestimatedate));
            $estimate->estimate_labor_total         =   $request->txtsumtotallabour;
            $estimate->estimate_parts_total         =   $request->txtsumtotalparts;
            $estimate->estimate_tax                 =   $request->txtsumtotaltax;
            $estimate->estimate_total               =   $request->txtsumtotaldueamountexcepttax;
            $estimate->estimate_total_inctax        =   $request->txtsumtotaldueamount;
            $estimate->estimate_carOwnerApproval    =   "pending";
            $estimate->estimate_status              =   "1";
            $estimate->save();


            // Store related labor items
            $labourIds      = $request->txtlabourname;
            $laborhours     = $request->txtlabourhours;
            $laborcost      = $request->txtlabourcost;
            $labortotalcost = $request->txttotallabourcust;
            $labortax       = $request->txtlabourtax;
            $laborgrandtotal= $request->txtlabourtotal;

            foreach ($labourIds as $index => $labourtitle) {
                $labor = new EstimateLaborModel();
                $labor->estimate_labor_estimate_id      = $estimate->estimate_id;
                $labor->estimate_labor_reference_id     = "1";
                $labor->estimate_labor_reference_type   = "1";
                $labor->estimate_labor_item             = $labourtitle;
                $labor->estimate_labor_rate             = $laborcost[$index];
                $labor->estimate_labor_hours            = $laborhours[$index];
                $labor->estimate_labor_cost             = $labortotalcost[$index];
                $labor->estimate_labor_tax              = $labortax[$index];
                $labor->estimate_labor_total            = $laborgrandtotal[$index];
                $labor->estimate_labor_status           = "1";
                $labor->save();
            }

            // Store related product items
            $productIds     = $request->txtproductname;
            $productqty     = $request->txtproductqty;
            $productprice   = $request->txtproductprice;
            $productmarkup  = $request->txtproductcost;
            $producttax     = $request->txtproducttax;
            $producttotal   = $request->txtproducttotalprice;
            $producttitle   = $request->txtproducttitle;

            foreach ($productIds as $index => $productid) {
                $product = new EstimatePartsModel();
                $product->estimate_parts_estimate_id    = $estimate->estimate_id;
                $product->estimate_parts_reference_id   = "1";
                $product->estimate_parts_reference_type = "1";
                $product->estimate_parts_product_id     = $productid;
                $product->estimate_parts_product_name   = $producttitle[$index];
                $product->estimate_parts_quantity       = $productqty[$index];
                $product->estimate_parts_cost           = $productprice[$index];
                $product->estimate_parts_markup         = $productmarkup[$index];
                $product->estimate_parts_tax            = $producttax[$index];
                $product->estimate_parts_total          = $producttotal[$index];
                $product->estimate_parts_status         = "1";
                $product->save();
            }

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'Booking Estimate generated successfully.'
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

    function generateUniqueEsimateNumber()
    {
        do {
            $number = 'EST' . random_int(100000, 999999); // Generates like PR659808
        } while (EstimateModel::where('estimate_estimate_no', $number)->exists());

        return $number;
    }

    public function list()
    {
        $user = Auth::user();
        $user_id = $user->id;

        return view('garage-owner.estimate.list');
    }

    public function getEstimateData(Request $request)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $estimate = EstimateModel::select('tbl_estimate.*', 'users.name as client_name', 'tbl_vehicles.number_plate as number_plate', 'tbl_vehicles.modelbrand as vehicle')
                        ->leftJoin('users', 'tbl_estimate.estimate_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_estimate.estimate_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_estimate.estimate_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->whereNull('tbl_estimate.deleted_at')
                        ->orderBy('tbl_estimate.estimate_id', 'desc');

        return DataTables::of($estimate)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('estimate_id', 'like', "%{$search}%")
                        ->orWhere('estimate_booking_id', 'like', "%{$search}%")
                        ->orWhere('estimate_estimate_no', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%")
                        ->orWhere('number_plate', 'like', "%{$search}%")
                        ->orWhere('vehicle', 'like', "%{$search}%")
                        ->orWhere('estimate_total_inctax', 'like', "%{$search}%")
                        ->orWhere('estimate_total', 'like', "%{$search}%")
                        ->orWhere('estimate_date', 'like', "%{$search}%")
                        ->orWhere('estimate_carOwnerApproval', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('estimate_id', fn($estimate) => $estimate->estimate_id)
            ->addColumn('estimate_booking_id', fn($estimate) => $estimate->estimate_booking_id)
            ->addColumn('estimate_estimate_no', fn($estimate) => $estimate->estimate_estimate_no)
            ->addColumn('client_name', fn($estimate) => $estimate->client_name)
            ->addColumn('number_plate', fn($estimate) => $estimate->number_plate)
            ->addColumn('vehicle', content: fn($estimate) => $estimate->vehicle)
            ->addColumn('estimate_total_inctax', fn($estimate) => $estimate->estimate_total_inctax)
            ->addColumn('estimate_total', fn($estimate) => $estimate->estimate_total)
            ->addColumn('estimate_date', fn($estimate) => date("Y-m-d", strtotime($estimate->estimate_date)))
            ->addColumn('estimate_carOwnerApproval', function ($estimate) {
                if( $estimate->estimate_carOwnerApproval == "approved" )
                {
                    return '<span class="text-success">Approved</span>';
                }
                else if( $estimate->estimate_carOwnerApproval == "pending" )
                {
                    return '<span class="text-warning">Pending</span>';
                }
                {
                    return '<span class="text-danger">Rejected</span>';
                }
            })
            ->addColumn('action', function ($estimate) {
                if( $estimate->estimate_carOwnerApproval == "approved" )
                {
                    return '<a href="javascript:void(0);" class="btn btn-soft-success btn-border btn-icon shadow-none disabled" title="Edit"><i class="ri-edit-line"></i></a>
                    <a href="javascript:;" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="Send Email"><i class="ri-mail-send-line"></i></a>
                    <a href="'.route('garage-owner.repair-order.new', $estimate->estimate_id).'" class="btn btn-soft-warning btn-border btn-icon shadow-none btn-select3" title="Repair Order"><i class="ri-tools-line"></i></a>
                    <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none disabled" title="Archive"><i class="ri-archive-2-line"></i></button>';
                }
                else{
                    return '<a href="'.route('garage-owner.estimate.edit', $estimate->estimate_id).'" class="btn btn-soft-success btn-border btn-icon shadow-none" title="Edit"><i class="ri-edit-line"></i></a>
                    <a href="javascript:;" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="Send Email"><i class="ri-mail-send-line"></i></a>
                    <a href="javascript:void(0);" class="btn btn-soft-warning btn-border btn-icon shadow-none btn-select3 disabled" title="Repair Order"><i class="ri-tools-line"></i></a>
                    <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Archive"><i class="ri-archive-2-line"></i></button>';
                }
            })
            ->rawColumns(['estimate_carOwnerApproval', 'action'])
            ->make(true);
    }

    public function edit($id)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $estimate_data = EstimateModel::select('tbl_estimate.*', 'users.name as client_name', 'users.id as client_id', 'users.address as client_address', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle', 'tbl_booking.booking_date_time as booking_date')
                        ->leftJoin('users', 'tbl_estimate.estimate_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_estimate.estimate_vehicle_id', '=', 'tbl_vehicles.id')
                        ->leftJoin('tbl_booking', 'tbl_estimate.estimate_booking_id', '=', 'tbl_booking.booking_id')
                        ->where('tbl_estimate.estimate_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->where('tbl_estimate.estimate_id', $id)
                        ->whereNull('tbl_estimate.deleted_at')
                        ->first();

        //echo "<pre>"; print_r($estimate_data); die;

        $labour_data = EstimateLaborModel::where("estimate_labor_estimate_id", $estimate_data->estimate_id)
                                            ->where("estimate_labor_reference_type", "1")
                                            ->get();
        //echo "<pre>"; print_r($labour_data); die;

        $product_data = EstimatePartsModel::select("tbl_estimate_parts.*", "tbl_products.product_name as product_name")
                                            ->leftJoin('tbl_products', 'tbl_products.product_id', '=', 'tbl_estimate_parts.estimate_parts_product_id')
                                            ->where("estimate_parts_estimate_id", $estimate_data->estimate_id)
                                            ->where("estimate_parts_reference_type", "1")
                                            ->get();

        $product_list = ProductModel::where('product_garage_owner_id', $user_id)
                                    ->orderBy('product_name', 'asc')
                                    ->get();

        $setting_data = SettingModel::where("setting_garage_id", $user_id)->whereNull('deleted_at')->first();

        return view('garage-owner.estimate.edit', compact('estimate_data', 'labour_data', 'product_data', 'product_list', 'setting_data'));
    }

    public function getProductData(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $data = $request->all();

        $productData = ProductModel::whereNull('deleted_at')
                                        ->findOrFail($data['productId']);

        //echo "<pre>"; print_r($productData); die;

        if($productData )
        {
            $invoice_data = array(
                "product_id"    =>  $productData->product_id,
                "product_name"  =>  $productData->product_name,
                "product_price" =>  $productData->product_price,
            );
            return response()->json(['status' => 'success', 'data' => $invoice_data]);
        }
        else
        {
            return response()->json(['status' => 'false', 'data' => array()]);
        }
    }

    public function update(Request $request)
    {
        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtestimatedate'               => 'required|string|max:30',
            'txtsumtotallabour'             => 'required|string|max:50',
            'txtsumtotalparts'              => 'required|string|max:50',
            'txtsumtotaltax'                => 'required|string|max:50',
            'txtsumtotaldueamountexcepttax' => 'required|string|max:50',
            'txtsumtotaldueamount'          => 'required|string|max:50',
            'txtbookingid'                  => 'required|string|max:50',
            'txtcustomerid'                 => 'required|string|max:50',
            'txtvehicleid'                  => 'required|string|max:50',
            'txtestimateid'                 => 'required|string|max:50',
            'txtestimatestatus'             => 'required|string|max:50'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {

            $updateEstimate = EstimateModel::where('estimate_garage_id', $garage_Owner->id)
                                            ->where('estimate_id', $request->txtestimateid)
                                            ->firstOrFail();
            //echo "<pre>"; print_r($updateEstimate); die;
            // Store booking record

            $updateEstimate->estimate_booking_id          =   $request->txtbookingid;
            $updateEstimate->estimate_garage_id           =   $garage_Owner->id;
            $updateEstimate->estimate_customer_id         =   $request->txtcustomerid;
            $updateEstimate->estimate_vehicle_id          =   $request->txtvehicleid;
            $updateEstimate->estimate_date                =   date("Y-m-d", strtotime($request->txtestimatedate));
            $updateEstimate->estimate_labor_total         =   $request->txtsumtotallabour;
            $updateEstimate->estimate_parts_total         =   $request->txtsumtotalparts;
            $updateEstimate->estimate_tax                 =   $request->txtsumtotaltax;
            $updateEstimate->estimate_total               =   $request->txtsumtotaldueamountexcepttax;
            $updateEstimate->estimate_total_inctax        =   $request->txtsumtotaldueamount;
            $updateEstimate->estimate_carOwnerApproval    =   $request->txtestimatestatus;
            $updateEstimate->estimate_status              =   "1";
            $updateEstimate->save();

            EstimateLaborModel::where('estimate_labor_estimate_id', $updateEstimate->estimate_id)
                                ->where('estimate_labor_reference_id', "1")
                                ->where('estimate_labor_reference_type', "1")
                                ->delete();

            // Store related labor items
            $labourIds      = $request->txtlabourname;
            $laborhours     = $request->txtlabourhours;
            $laborcost      = $request->txtlabourcost;
            $labortotalcost = $request->txttotallabourcust;
            $labortax       = $request->txtlabourtax;
            $laborgrandtotal= $request->txtlabourtotal;

            foreach ($labourIds as $index => $labourtitle) {
                $labor = new EstimateLaborModel();
                $labor->estimate_labor_estimate_id      = $updateEstimate->estimate_id;
                $labor->estimate_labor_reference_id     = "1";
                $labor->estimate_labor_reference_type   = "1";
                $labor->estimate_labor_item             = $labourtitle;
                $labor->estimate_labor_rate             = $laborcost[$index];
                $labor->estimate_labor_hours            = $laborhours[$index];
                $labor->estimate_labor_cost             = $labortotalcost[$index];
                $labor->estimate_labor_tax              = $labortax[$index];
                $labor->estimate_labor_total            = $laborgrandtotal[$index];
                $labor->estimate_labor_status           = "1";
                $labor->save();
            }

            EstimatePartsModel::where('estimate_parts_estimate_id', $updateEstimate->estimate_id)
                                ->where('estimate_parts_reference_id', "1")
                                ->where('estimate_parts_reference_type', "1")
                                ->delete();

            // Store related product items
            $productIds     = $request->txtproductname;
            $productqty     = $request->txtproductqty;
            $productprice   = $request->txtproductprice;
            $productmarkup  = $request->txtproductcost;
            $producttax     = $request->txtproducttax;
            $producttotal   = $request->txtproducttotalprice;
            $producttitle   = $request->txtproducttitle;

            foreach ($productIds as $index => $productid) {
                $product = new EstimatePartsModel();
                $product->estimate_parts_estimate_id    = $updateEstimate->estimate_id;
                $product->estimate_parts_reference_id   = "1";
                $product->estimate_parts_reference_type = "1";
                $product->estimate_parts_product_id     = $productid;
                $product->estimate_parts_product_name   = $producttitle[$index];
                $product->estimate_parts_quantity       = $productqty[$index];
                $product->estimate_parts_cost           = $productprice[$index];
                $product->estimate_parts_markup         = $productmarkup[$index];
                $product->estimate_parts_tax            = $producttax[$index];
                $product->estimate_parts_total          = $producttotal[$index];
                $product->estimate_parts_status         = "1";
                $product->save();
            }

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'Booking Estimate updated successfully.'
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
}
