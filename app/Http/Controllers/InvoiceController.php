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
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class InvoiceController extends Controller
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

        $repair_order_data = RepairOrderModel::select('tbl_repair_order.*', 'users.name as client_name', 'users.address as client_address', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle', 'tbl_estimate.estimate_labor_total', 'tbl_estimate.estimate_parts_total', 'tbl_estimate.estimate_tax', 'tbl_estimate.estimate_total_inctax', 'tbl_estimate.estimate_total')
                        ->leftJoin('users', 'tbl_repair_order.repairorder_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_repair_order.repairorder_vehicle_id', '=', 'tbl_vehicles.id')
                        ->leftJoin('tbl_estimate', 'tbl_repair_order.repairorder_estimate_id', '=', 'tbl_estimate.estimate_id')
                        ->where('tbl_repair_order.repairorder_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->where('tbl_repair_order.repairorder_id', $id)
                        ->whereNull('tbl_repair_order.deleted_at')
                        ->first();

        $labour_data = EstimateLaborModel::where("estimate_labor_estimate_id", $repair_order_data->repairorder_estimate_id)
                                        ->get();

        $product_data = EstimatePartsModel::select("tbl_estimate_parts.*", "tbl_products.product_name as product_name")
                                            ->leftJoin('tbl_products', 'tbl_products.product_id', '=', 'tbl_estimate_parts.estimate_parts_product_id')
                                            ->where("estimate_parts_estimate_id", $repair_order_data->repairorder_estimate_id)
                                            ->get();

        $product_list = ProductModel::where('product_garage_owner_id', $user_id)
                                    ->orderBy('product_name', 'asc')
                                    ->get();

        //echo '<pre>'; print_r($repair_order_data); die;

        return view('garage-owner.invoice.new', compact('repair_order_data', 'labour_data', 'product_data', 'product_list'));
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
            'txtrepairorderid'              => 'required|string|max:50',
            'txtbookingid'                  => 'required|string|max:50',
            'txtcustomerid'                 => 'required|string|max:50',
            'txtvehicleid'                  => 'required|string|max:50',
            'txtestimateid'                 => 'required|string|max:50',
            'txtgarageid'                   => 'required|string|max:50'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            // Store booking record
            $invoice = new InvoiceModel();
            $invoice->invoice_repairorder_id    =   $request->txtrepairorderid;
            $invoice->invoice_estimate_id       =   $request->txtestimateid;
            $invoice->invoice_booking_id        =   $request->txtbookingid;
            $invoice->invoice_no                =   $this->generateUniqueInvoiceNumber();
            $invoice->invoice_type              =   "Booking";
            $invoice->invoice_garage_id         =   $request->txtgarageid;
            $invoice->invoice_customer_id       =   $request->txtcustomerid;
            $invoice->invoice_vehicle_id        =   $request->txtvehicleid;
            $invoice->invoice_date              =   date("Y-m-d", strtotime($request->txtestimatedate));
            $invoice->invoice_labor_total       =   $request->txtsumtotallabour;
            $invoice->invoice_parts_total       =   $request->txtsumtotalparts;
            $invoice->invoice_tax               =   $request->txtsumtotaltax;
            $invoice->invoice_total             =   $request->txtsumtotaldueamountexcepttax;
            $invoice->invoice_total_inctax      =   $request->txtsumtotaldueamount;
            $invoice->invoice_payment_status    =   "0";
            $invoice->invoice_status            =   "1";

            if( $request->txtextranotes )
            {
                $invoice->invoice_notes = $request->txtextranotes;
            }

            $invoice->save();

            // Store related labor items
            $labourIds      = $request->txtlabourname;
            $laborhours     = $request->txtlabourhours;
            $laborcost      = $request->txtlabourcost;
            $labortotalcost = $request->txttotallabourcust;
            $labortax       = $request->txtlabourtax;
            $laborgrandtotal= $request->txtlabourtotal;

            foreach ($labourIds as $index => $labourtitle) {
                $labor = new EstimateLaborModel();
                $labor->estimate_labor_estimate_id      = $invoice->invoice_id;
                $labor->estimate_labor_reference_id     = "2";
                $labor->estimate_labor_reference_type   = "2";
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
                $product->estimate_parts_estimate_id    = $invoice->invoice_id;
                $product->estimate_parts_reference_id   = "2";
                $product->estimate_parts_reference_type = "2";
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
                'message' => 'Invoice generated successfully.'
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
        $user = Auth::user();
        $user_id = $user->id;

        $invoice_data = InvoiceModel::whereNull('tbl_invoices.deleted_at')
                                                ->get();

        return view('garage-owner.invoice.list', compact('invoice_data'));
    }

    public function getInvoiceData(Request $request)
    {
        $user = Auth::user();

        $user_id = $user->id;

        $invoice = InvoiceModel::select('tbl_invoices.*', 'users.name as client_name', 'tbl_vehicles.number_plate as number_plate', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle')
                        ->leftJoin('users', 'tbl_invoices.invoice_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_invoices.invoice_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_invoices.invoice_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->whereNull('tbl_invoices.deleted_at')
                        ->orderBy('tbl_invoices.invoice_id', 'desc');

        return DataTables::of($invoice)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('invoice_id', 'like', "%{$search}%")
                        ->orWhere('invoice_booking_id', 'like', "%{$search}%")
                        ->orWhere('invoice_no', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%")
                        ->orWhere('number_plate', 'like', "%{$search}%")
                        ->orWhere('vin', 'like', "%{$search}%")
                        ->orWhere('vehicle', 'like', "%{$search}%")
                        ->orWhere('invoice_total_inctax', 'like', "%{$search}%")
                        ->orWhere('invoice_total', 'like', "%{$search}%")
                        ->orWhere('invoice_date', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('invoice_id', fn($invoice) => $invoice->invoice_id)
            ->addColumn('invoice_booking_id', fn($invoice) => $invoice->invoice_booking_id)
            ->addColumn('invoice_no', fn($invoice) => $invoice->invoice_no)
            ->addColumn('client_name', fn($invoice) => $invoice->client_name)
            ->addColumn('number_plate', fn($invoice) => $invoice->number_plate)
            ->addColumn('vehicle', content: fn($invoice) => $invoice->vehicle)
            ->addColumn('vin', content: fn($invoice) => $invoice->vin)
            ->addColumn('invoice_total_inctax', fn($invoice) => $invoice->invoice_total_inctax)
            ->addColumn('invoice_total', fn($invoice) => $invoice->invoice_total)
            ->addColumn('invoice_date', fn($repair_order) => date("Y-m-d", strtotime($repair_order->invoice_date)))
            ->addColumn('action', fn($invoice) =>
                '<button type="button" class="btn btn-soft-info btn-border btn-icon shadow-none btndisplayinvoicedetails" title="View PDF" data-invoiceid="'.$invoice->invoice_id.'" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInvoice" aria-controls="offcanvasRight"><i class="ri-file-pdf-2-line"></i></button>
                <a href="javascript:void(0);" class="btn btn-soft-success btn-border btn-icon shadow-none" title="Edit"><i class="ri-edit-line"></i></a>
                <a href="javascript:;" class="btn btn-soft-primary btn-border btn-icon shadow-none" title="Send Email"><i class="ri-mail-send-line"></i></a>
                <button type="button" class="btn btn-soft-warning btn-border btn-icon shadow-none" title="Pay" data-bs-toggle="offcanvas" data-bs-target="#sidebarPayment" aria-controls="offcanvasRight"><i class="ri-secure-payment-line"></i></button>
                <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Archive"><i class="ri-archive-2-line"></i></button>'
            )
            ->rawColumns(['action'])
            ->make(true);
    }

    function generateUniqueInvoiceNumber()
    {
        do {
            $number = 'INV' . random_int(100000, 999999); // Generates like PR659808
        } while (InvoiceModel::where('invoice_no', $number)->exists());

        return $number;
    }

    public function getViewInvoiceDetails(Request $request)
    {
        $user = Auth::user();

        $data = $request->all(); // Get all input data
        //echo "<pre>"; print_r($data); die;
        $user_id = $user->id;

        $invoiceData = InvoiceModel::select('tbl_invoices.*', 'users.name as client_name', 'users.countrycode', 'users.mobilenumber', 'users.address', 'users.email', 'tbl_vehicles.number_plate as number_plate', 'tbl_vehicles.vin as vin', 'tbl_vehicles.modelbrand as vehicle')
                        ->leftJoin('users', 'tbl_invoices.invoice_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_invoices.invoice_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_invoices.invoice_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->whereNull('tbl_invoices.deleted_at')
                        ->findOrFail($data['invoiceId']);


        $labour_data = EstimateLaborModel::where("estimate_labor_estimate_id", $invoiceData->invoice_id)
                                            ->where("estimate_labor_reference_type", "2")
                                            ->get();

        $product_data = EstimatePartsModel::select("tbl_estimate_parts.*", "tbl_products.product_name as product_name")
                                            ->leftJoin('tbl_products', 'tbl_products.product_id', '=', 'tbl_estimate_parts.estimate_parts_product_id')
                                            ->where("estimate_parts_estimate_id", $invoiceData->invoice_id)
                                            ->where("estimate_parts_reference_type", "2")
                                            ->get();

        //echo "<pre>"; print_r($invoiceData); die;

        $invoice_data = array(
            "customer_name"         =>  $invoiceData["client_name"],
            "customer_email"        =>  $invoiceData["email"],
            "customer_contact"      =>  "+".$invoiceData["countrycode"].$invoiceData["mobilenumber"],
            "customer_address"      =>  $invoiceData["address"],
            "vehicle_name"          =>  $invoiceData["vehicle"],
            "vehicle_reg_no"        =>  $invoiceData["number_plate"],
            "vehicle_vin"           =>  $invoiceData["vin"],
            "total_labour"          =>  $invoiceData["invoice_labor_total"],
            "total_parts"           =>  $invoiceData["invoice_parts_total"],
            "total_tax"             =>  $invoiceData["invoice_tax"],
            "grand_total"           =>  $invoiceData["invoice_total_inctax"],
            "labour_data"           =>  $labour_data,
            "item_data"             =>  $product_data

        );
        return response()->json($invoice_data);
    }
}
