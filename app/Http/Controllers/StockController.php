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

class StockController extends Controller
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

        return view('garage-owner.stock.list', compact('supplier', 'product'));
    }

    public function getStockData(Request $request)
    {
        $user = Auth::user();

        $id = $user->id;

        $stock = ProductModel::query()
                            ->leftJoin('tbl_purchase_item', 'tbl_products.product_id', '=', 'tbl_purchase_item.purchase_item_product_id')
                            ->leftJoin('tbl_purchase', 'tbl_purchase.purchase_id', '=', 'tbl_purchase_item.purchase_item_purchase_id')
                            ->leftJoin('users', 'users.id', '=', 'tbl_purchase.purchase_supplier_id')
                            ->whereNull('tbl_products.deleted_at')
                            ->groupBy(
                                'tbl_products.product_id',
                                'tbl_products.product_number',
                                'tbl_products.product_name',
                                'tbl_products.product_status',
                                'users.businessname'
                            )
                            ->select([
                                'tbl_products.product_id',
                                'tbl_products.product_number',
                                'tbl_products.product_name',
                                'tbl_products.product_status',
                                'users.businessname as business_name',
                            ])
                            ->selectRaw('COALESCE(SUM(tbl_purchase_item.purchase_item_qty), 0) as total_qty')
                            ->orderBy('tbl_products.product_id', 'desc');
                            // ->get()
                            // ->toArray();

        //echo "<pre>"; print_r($stock); die;

        return DataTables::of($stock)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('product_id', 'like', "%{$search}%")
                        ->orWhere('product_number', 'like', "%{$search}%")
                        ->orWhere('product_name', 'like', "%{$search}%")
                        ->orWhere('users.businessname', 'like', "%{$search}%")
                        ->orWhere('tbl_purchase_item.purchase_item_qty', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('product_id', fn($stock) => $stock->product_id)
            ->addColumn('product_number', fn($stock) => $stock->product_number)
            ->addColumn('product_name', fn($stock) => $stock->product_name)
            ->addColumn('business_name', fn($stock) => $stock->business_name)
            ->addColumn('total_qty', fn($stock) => $stock->total_qty)
            ->addColumn('unit_of_masurement', "N/A")
            ->addColumn('status', function ($stock) {
                if( $stock->product_status == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', fn($stock) =>
                '<button type="button" class="btn btn-soft-primary btn-border btn-icon shadow-none getStockDetails" title="View" data-bs-toggle="offcanvas" data-bs-target="#sidebarViewInformation" aria-controls="offcanvasRight" data-purchaseid="'.$stock->product_id.'" data-supplierid="'.$stock->supplier_id.'"><i class="ri-eye-line"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
