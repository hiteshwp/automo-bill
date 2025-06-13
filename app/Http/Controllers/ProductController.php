<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Mail;
use Storage;

use Illuminate\Http\Request;
use App\Models\ProductModel;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
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

        $supplier = User::where('user_type', 'Supplier')
                        ->where('garage_owner_id',$user_id)
                        ->get();
        return view('garage-owner.products.list', compact('supplier'));
    }

    public function getProductData(Request $request)
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

        $product = ProductModel::select('tbl_products.*', 'users.name as supplier_name', 'users.businessname as company_name')
                        ->leftJoin('users', 'tbl_products.product_supplier_id', '=', 'users.id')
                        ->where('tbl_products.product_garage_owner_id', $id)
                        ->where('users.user_type', 'Supplier')
                        ->whereNull('tbl_products.deleted_at')
                        ->orderBy('tbl_products.product_id', 'desc');

        return DataTables::of($product)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('users.name', 'like', "%{$search}%")
                        ->orWhere('users.businessname', 'like', "%{$search}%")
                        ->orWhere('tbl_products.product_name', 'like', "%{$search}%")
                        ->orWhere('tbl_products.product_number', 'like', "%{$search}%")
                        ->orWhere('tbl_products.product_price', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('product_id', fn($product) => $product->product_id)
            ->addColumn('supplier_name', fn($product) => $product->supplier_name)
            ->addColumn('company_name', fn($product) => $product->company_name)
            ->addColumn('product_name', fn($product) => $product->product_name)
            ->addColumn('product_number', fn($product) => $product->product_number)
            ->addColumn('product_price', fn($product) => $product->product_price)
            ->addColumn('status', function ($product) {
                if( $product->product_status == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', fn($product) =>
                '<a href="#" title="Edit Supplier" class="btn btn-soft-success btn-border btn-icon shadow-none" data-bs-toggle="offcanvas" data-bs-target="#sidebarUpdateSupplier" aria-controls="offcanvasRight" data-supplierid="'.$product->id.'"><i class="ri-edit-line"></i></a>
                <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none" title="Archive"><i class="ri-archive-2-line"></i></button>'
            )
            ->rawColumns(['status', 'action'])
            ->make(true);
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

        $validator = Validator::make($request->all(), [
            'txtproductnumber'  => 'required|string|max:20',
            'txtproductname'    => 'required|string|max:100',
            'txtprice'          => 'required|string|max:15',
            'txtproductdate'    => 'nullable|string|max:15',
            'txtsupplier'       => 'nullable|string|max:15'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $product = new ProductModel();
        $product->product_supplier_id       = $request->txtsupplier;
        $product->product_name              = $request->txtproductname;
        $product->product_number            = $request->txtproductnumber;
        $product->product_price             = $request->txtprice;
        $product->product_date              = $request->txtproductdate;
        $product->product_garage_owner_id   = $garage_Owner->id;
        $product->product_status            = "1";    

        $product->save();
    
        return response()->json(['status' => 'success', 'message' => 'New Product data saved successfully.']);
    }
}
