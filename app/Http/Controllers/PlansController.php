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

class PlansController extends Controller
{
    public function __construct()
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }
    }

    public function index()
    {

    }

    public function myAccountView()
    {
        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        return view('garage-owner.plan.my-account');
    }
}
