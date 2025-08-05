<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Mail;
use Storage;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\PurchaseModel;
use App\Models\PurchaseItemModel;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PurchaseController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(403, 'Unauthorized');
        }
    }
    public function index()
    {
        $user = Auth::user();

        $user_id = $user->id;

        $supplier = User::where('user_type', 'Supplier')
                        ->where('garage_owner_id',$user_id)
                        ->get();

        $product = ProductModel::where('product_garage_owner_id',$user_id)
                        ->get();

        return view('garage-owner.purchase.list', compact('supplier', 'product'));
    }

    public function getPurchaseData(Request $request)
    {
        $user = Auth::user();

        $id = $user->id;

        $purchase = PurchaseModel::where('purchase_garage_owner_id', $id)
                        ->whereNull('deleted_at')
                        ->orderBy('purchase_id', 'desc');

                        //print_r($purchase);

        return DataTables::of($purchase)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('purchase_number', 'like', "%{$search}%")
                        ->orWhere('purchase_supplier_name', 'like', "%{$search}%")
                        ->orWhere('purchase_supplier_email', 'like', "%{$search}%")
                        ->orWhere('purchase_supplier_mobile', 'like', "%{$search}%")
                        ->orWhere('purchase_date', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('purchase_id', fn($purchase) => $purchase->purchase_id)
            ->addColumn('purchase_number', fn($purchase) => $purchase->purchase_number)
            ->addColumn('purchase_supplier_name', fn($purchase) => $purchase->purchase_supplier_name)
            ->addColumn('purchase_supplier_email', fn($purchase) => $purchase->purchase_supplier_email)
            ->addColumn('purchase_supplier_mobile', fn($purchase) => $purchase->purchase_supplier_mobile)
            ->addColumn('purchase_date', fn($purchase) => $purchase->purchase_date)
            ->addColumn('status', function ($purchase) {
                if( $purchase->purchase_status == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', fn($purchase) =>
                '<button type="button" class="btn btn-soft-primary btn-border btn-icon shadow-none getPurchaseDetails" title="View" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInformation" aria-controls="offcanvasRight" data-purchaseId="'.$purchase->purchase_id.'"><i class="ri-eye-line"></i></button>
                <a href="#" title="Edit Product" class="btn btn-soft-success btn-border btn-icon shadow-none editviewpurchaedetails" data-bs-toggle="offcanvas" data-bs-target="#sidebarEditPurchase" aria-controls="offcanvasRight" data-purchaseId="'.$purchase->purchase_id.'"><i class="ri-edit-line"></i></a>
                <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removepurchasedata" title="Archive" data-bs-toggle="offcanvas" data-bs-target="#removePurchaseNotificationModal" aria-controls="offcanvasRight" data-purchaseId="'.$purchase->purchase_id.'"><i class="ri-archive-2-line"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }

    public function getsupplierdetail(Request $request)
    {
        $garage_Owner = Auth::user();

        $data = $request->all(); // Get all input data

        $supplier = User::where('user_type', 'Supplier')
                        ->where('garage_owner_id', $garage_Owner->id)
                        ->findOrFail($data['supplierId']);

        $supplier_data = array(
            "supplier_id"           =>  $supplier["id"],
            "supplier_name"         =>  $supplier["name"],
            "supplier_email"        =>  $supplier["email"],
            "supplier_address"      =>  $supplier["address"],
            "supplier_mobilenumber" =>  $supplier["mobilenumber"],
            "supplier_countrycode"  =>  $supplier["countrycode"],
        );
        return response()->json($supplier_data);
    }

    public function getproductdetail(Request $request)
    {
        $garage_Owner = Auth::user();

        $data = $request->all(); // Get all input data

        $user_id = $garage_Owner->id;

        $productData = ProductModel::where('product_garage_owner_id',$user_id)
                                    ->findOrFail($data['productId']);

        $product_data = array(
            "product_id"            =>  $productData["product_id"],
            "product_number"        =>  $productData["product_number"],
            "product_price"         =>  $productData["product_price"],
        );
        return response()->json($product_data);
    }

    public function store(Request $request)
    {
        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtnewsuppliername'            => 'required|string|max:100',
            'txtnewpurchasedate'            => 'required|string|max:15',
            'txtnewpurchaseemail'           => 'required|string|max:100',
            'txtnewpurchasemobileno'        => 'required|string|max:100',
            'txtnewpurchasebillingaddress'  => 'required|string|max:100'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            // Store purchase record
            $purchase = new PurchaseModel();
            $purchase->purchase_supplier_id         = $request->txtnewsuppliername;
            $purchase->purchase_date                = $request->txtnewpurchasedate;
            $purchase->purchase_supplier_name       = $request->txtnewpurchasesuppliername;
            $purchase->purchase_supplier_email      = $request->txtnewpurchaseemail;
            $purchase->purchase_supplier_mobile     = $request->txtnewpurchasemobileno;
            $purchase->purchase_garage_owner_id     = $garage_Owner->id;
            $purchase->purchase_number              = $this->generateUniquePurchaseNumber();
            $purchase->purchase_supplier_address    = $request->txtnewpurchasebillingaddress;
            $purchase->purchase_status              = "1";    
            $purchase->save();

            // Store related purchase items
            $productIds = $request->txtnewpurchaseloopproductname;
            $quantities = $request->txtnewpurchaseloopqty;
            $productNos = $request->txtnewpurchaseloopproductno;
            $prices     = $request->txtnewpurchaseloopprice;
            $totals     = $request->txtnewpurchaselooptotalamount;

            foreach ($productIds as $index => $productId) {
                $item = new PurchaseItemModel();
                $item->purchase_item_purchase_id  = $purchase->purchase_id;
                $item->purchase_item_product_id   = $productId;
                $item->purchase_item_qty          = $quantities[$index];
                $item->purchase_item_price        = $prices[$index];
                $item->purchase_item_total_amount = $totals[$index];
                $item->purchase_item_status       = "1";
                $item->save();
            }

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'New Purchase data saved successfully.'
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

    function generateUniquePurchaseNumber()
    {
        do {
            $number = 'PUR' . random_int(100000, 999999); // Generates like PR659808
        } while (PurchaseModel::where('purchase_number', $number)->exists());

        return $number;
    }

    function getViewPurchaseDetails(Request $request)
    {

        $garage_Owner = Auth::user();

        $data = $request->all(); // Get all input data

        $user_id = $garage_Owner->id;

        $purchaseData = PurchaseModel::where('purchase_garage_owner_id',$user_id)
                                    ->whereNull('deleted_at')   
                                    ->findOrFail($data['purchaseId']);

        $purchaseItemData = PurchaseItemModel::select("tbl_purchase_item.*", "tbl_products.product_name", "tbl_products.product_number")
                                                ->leftJoin("tbl_products", "tbl_products.product_id","=", "tbl_purchase_item.purchase_item_product_id")
                                                ->addSelect('tbl_products.product_name as product_name')
                                                ->addSelect('tbl_products.product_number as product_number')
                                                ->where('tbl_purchase_item.purchase_item_purchase_id', $data['purchaseId'])
                                                ->whereNull('tbl_purchase_item.deleted_at')
                                                ->get();   
                                                
        $product = ProductModel::where('product_garage_owner_id',$user_id)
                                ->get();

        $purchase_data = array(
            "purchase_id"               =>  $purchaseData["purchase_id"],
            "purchase_date"             =>  $purchaseData["purchase_date"],
            "purchase_supplier_name"    =>  $purchaseData["purchase_supplier_name"],
            "purchase_supplier_id"      =>  $purchaseData["purchase_supplier_id"],
            "purchase_number"           =>  $purchaseData["purchase_number"],
            "purchase_supplier_email"   =>  $purchaseData["purchase_supplier_email"],
            "purchase_supplier_mobile"  =>  $purchaseData["purchase_supplier_mobile"],
            "purchase_supplier_address" =>  $purchaseData["purchase_supplier_address"],
            "purchase_items"            =>  $purchaseItemData->map(function ($item) {
                return [
                    'item_id'                   => $item->purchase_item_id,
                    'purchase_item_product_id'  => $item->purchase_item_product_id,
                    'product_name'              => $item->product_name,
                    'product_number'            => $item->product_number,
                    'purchase_item_qty'         => $item->purchase_item_qty,
                    'purchase_item_price'       => $item->purchase_item_price,
                    'purchase_item_total_amount'=> $item->purchase_item_total_amount,
                ];
            }),
            "product_list"              =>  $product
        );
        return response()->json($purchase_data);
    }

    public function update(Request $request)
    {
        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtupdatesuppliername'            => 'required|string|max:100',
            'txtupdatepurchasedate'            => 'required|string|max:15',
            'txtupdatepurchaseemail'           => 'required|string|max:100',
            'txtupdatepurchasemobileno'        => 'required|string|max:100',
            'txtupdatepurchasebillingaddress'  => 'required|string|max:100'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            // Store purchase record
            $purchase = PurchaseModel::where('purchase_garage_owner_id', $garage_Owner->id)
                    ->where('purchase_id', $request->txtupdatepurchaseid)
                    ->firstOrFail();
            $purchase->purchase_supplier_id         = $request->txtupdatesuppliername;
            $purchase->purchase_date                = $request->txtupdatepurchasedate;
            $purchase->purchase_supplier_name       = $request->txtupdatepurchasesppliername;
            $purchase->purchase_supplier_email      = $request->txtupdatepurchaseemail;
            $purchase->purchase_supplier_mobile     = $request->txtupdatepurchasemobileno;
            $purchase->purchase_supplier_address    = $request->txtupdatepurchasebillingaddress;   
            $purchase->save();

            PurchaseItemModel::where('purchase_item_purchase_id', $purchase->purchase_id)->delete();

            // Store related purchase items
            $productIds = $request->txtupdatepurchaseloopproductname;
            $quantities = $request->txtupdatepurchaseloopqty;
            $productNos = $request->txtupdatepurchaseloopproductno;
            $prices     = $request->txtupdatepurchaseloopprice;
            $totals     = $request->txtupdatepurchaselooptotalamount;

            foreach ($productIds as $index => $productId) {
                $item = new PurchaseItemModel();
                $item->purchase_item_purchase_id  = $purchase->purchase_id;
                $item->purchase_item_product_id   = $productId;
                $item->purchase_item_qty          = $quantities[$index];
                $item->purchase_item_price        = $prices[$index];
                $item->purchase_item_total_amount = $totals[$index];
                $item->save();
            }

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'Purchase data updated successfully.'
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

    public function removedetails(Request $request)
    {
        $garageOwner = Auth::user();

        $product = PurchaseModel::where('purchase_garage_owner_id', $garageOwner->id)->find($request->id);
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Purchase not found'], 404);
        }

        $product->delete(); // now performs soft delete

        return response()->json(['status' => 'success', 'message' => 'Purchase archived successfully.']);
    }
}
