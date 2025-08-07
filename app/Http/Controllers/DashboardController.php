<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BookingModel;
use App\Models\RepairOrderModel;
use App\Models\InvoiceModel;

class DashboardController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();

        if ($user->user_type === 'Super Admin') {
            return redirect()->route('dashboard.super-admin');
        } elseif ($user->user_type === 'Garage Owner') {
            return redirect()->route('dashboard.garage-owner');
        } else {
            return redirect()->route('dashboard.user');
        }
    }

    public function superAdmin()
    {
        return view('dashboard.super-admin');
    }

    public function garageOwner()
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();
        $user_id = $user->id;

        $total_booking = BookingModel::where('booking_garage_id',$user_id)
                                        ->whereNull('deleted_at')
                                        ->count();

        $total_repair_order = RepairOrderModel::where('repairorder_garage_id',$user_id)
                                        ->whereNull('deleted_at')
                                        ->count();

        $booking_data = BookingModel::select('tbl_booking.*', 'users.name as client_name', 'users.email as client_email', 'tbl_vehicles.number_plate as number_plate')
                        ->leftJoin('users', 'tbl_booking.booking_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_booking.booking_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_booking.booking_garage_id', $user_id)
                        ->where('users.user_type', 'User')
                        ->whereNull('tbl_booking.deleted_at')
                        ->orderBy('tbl_booking.booking_id', 'desc')
                        ->limit(5)
                        ->get();

        //echo "<pre>"; print_r($booking_data); die;

        return view('dashboard.garage-owner', compact('total_booking', 'total_repair_order', 'booking_data'));
    }

    public function userDashboard()
    {
        return view('dashboard.user');
    }
}
