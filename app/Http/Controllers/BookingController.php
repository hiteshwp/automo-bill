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
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class BookingController extends Controller
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
    public function index()
    {
        $user = Auth::user();
        $user_id = $user->id;

        $vehicle_list = Vehicle::select("tbl_vehicles.*", "users.name")
                                ->leftJoin("users", "tbl_vehicles.customer_id", "=", "users.id")
                                ->where('tbl_vehicles.garage_id', $user_id)
                                ->get();

        return view('garage-owner.booking.list', compact('vehicle_list'));
    }

    public function getBookingData(Request $request)
    {
        $user = Auth::user();

        $id = $user->id;

        $booking = BookingModel::select('tbl_booking.*', 'users.name as client_name', 'tbl_vehicles.number_plate as number_plate')
                        ->leftJoin('users', 'tbl_booking.booking_customer_id', '=', 'users.id')
                        ->leftJoin('tbl_vehicles', 'tbl_booking.booking_vehicle_id', '=', 'tbl_vehicles.id')
                        ->where('tbl_booking.booking_garage_id', $id)
                        ->where('users.user_type', 'User')
                        ->whereNull('tbl_booking.deleted_at')
                        ->orderBy('tbl_booking.booking_id', 'desc');

        return DataTables::of($booking)
            ->filter(function ($query) use ($request) {
                if (!empty($request->search['value'])) {
                    $search = $request->search['value'];
                    $query->where(function ($q) use ($search) {
                        $q->where('booking_date_time', 'like', "%{$search}%")
                        ->orWhere('client_name', 'like', "%{$search}%")
                        ->orWhere('number_plate', 'like', "%{$search}%")
                        ->orWhere('booking_details', 'like', "%{$search}%")
                        ->orWhere('booking_is_covidsafe', 'like', "%{$search}%")
                        ->orWhere('booking_is_service', 'like', "%{$search}%");
                    });
                }
            })
            ->addColumn('booking_id', fn($booking) => $booking->booking_id)
            ->addColumn('booking_date_time', fn($booking) => date("Y-m-d h:i A", strtotime($booking->booking_date_time)))
            ->addColumn('client_name', fn($booking) => $booking->client_name)
            ->addColumn('number_plate', fn($booking) => $booking->number_plate)
            ->addColumn('booking_details', fn($booking) => $booking->booking_details)
            ->addColumn('booking_is_covidsafe', function ($booking) {
                if( $booking->booking_is_covidsafe == "1" )
                {
                    return '<span class="text-success">Normal Booking</span>';
                }
                else
                {
                    return '<span class="text-danger">Covid Safe Booking</span>';
                }
            })
            ->addColumn('booking_is_service', function ($booking) {
                if( $booking->booking_is_service == "1" )
                {
                    return '<span class="badge bg-success-subtle text-success">Active</span>';
                }
                else
                {
                    return '<span class="badge bg-danger-subtle text-danger">Deactive</span>';
                }
            })
            ->addColumn('action', function($booking)
            {
                if ($booking->booking_status == 1 && $booking->booking_is_covidsafe == 2) {
                    return '
                        <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none getbookingDetails btn-select2" title="View" data-bs-toggle="offcanvas" data-bs-target="#sidebarEditBooking" aria-controls="offcanvasRight" data-bookingid="'.$booking->booking_id.'"><i class="ri-edit-line"></i></button>
                        <a href="estimate-invoice.html" class="btn btn-soft-warning btn-border btn-icon shadow-none disabled" title="Estimates"><i class="ri-calculator-line"></i></a>
                        <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none convertnormalbookingdata" title="Normal Booking" data-bs-toggle="offcanvas" data-bs-target="#covertNormalBookingNotificationModal" aria-controls="offcanvasRight" data-bookingid="'.$booking->booking_id.'"><i class="ri-calendar-check-fill"></i></button>
                        <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removebookingdata" title="Archive" data-bs-toggle="offcanvas" data-bs-target="#removebookingNotificationModal" aria-controls="offcanvasRight" data-bookingid="'.$booking->booking_id.'"><i class="ri-archive-2-line"></i></button>
                    ';
                } else {
                    return ' 
                        <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none getbookingDetails btn-select2" title="View" data-bs-toggle="offcanvas" data-bs-target="#sidebarEditBooking" aria-controls="offcanvasRight" data-bookingid="'.$booking->booking_id.'"><i class="ri-edit-line"></i></button>
                        <a href="'.route('garage-owner.estimate.new', $booking->booking_id).'" class="btn btn-soft-warning btn-border btn-icon shadow-none" title="Estimates"><i class="ri-calculator-line"></i></a>
                        <button type="button" class="btn btn-soft-success btn-border btn-icon shadow-none disabled" title="Normal Booking"><i class="ri-calendar-check-fill"></i></button>
                        <button type="button" class="btn btn-soft-danger btn-border btn-icon shadow-none removebookingdata" title="Archive" data-bs-toggle="offcanvas" data-bs-target="#removebookingNotificationModal" aria-controls="offcanvasRight" data-bookingid="'.$booking->booking_id.'"><i class="ri-archive-2-line"></i></button>';
                }
            })
            ->rawColumns(['booking_is_covidsafe', 'booking_is_service', 'action'])
            ->make(true);
    }

    public function getUserDetail(Request $request)
    {
        $user = Auth::user();
        $user_id = $user->id;

        $data = $request->all(); // Get all input data

        $users = User::where('user_type', 'User')
                        ->where('garage_owner_id', $user_id)
                        ->findOrFail($data['customerId']);

        $user_data = array(
            "user_id"   =>  $users["id"],
            "user_name" =>  $users["name"],
        );
        return response()->json($user_data);
    }

    public function store(Request $request)
    {
        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtbookingvehicle'                 => 'required|string|max:10',
            'txtbookingclientname'              => 'required|string|max:250',
            'ttxtbookingdatetime'               => 'required|string|max:100',
            'txtbookingdetails'                 => 'required|string|max:100',
            'txtcovidsafenotificationtemplate'  => 'required|string',
            'txtbookinguserid'                  => 'required|string|max:10'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            // Store booking record
            $booking = new BookingModel();
            $booking->booking_garage_id     = $garage_Owner->id;;
            $booking->booking_vehicle_id    = $request->txtbookingvehicle;
            $booking->booking_customer_id   = $request->txtbookinguserid;
            $booking->booking_date          = $request->txtbookingdate;
            $booking->booking_time          = $request->txtbookingtime;
            $booking->booking_date_time     = $request->ttxtbookingdatetime;
            $booking->booking_details       = $request->txtbookingdetails;
            $booking->booking_sms_template  = $request->txtcovidsafenotificationtemplate;
            $booking->booking_status        = "1";  
            
            if( $request->txtbookingservice )
            {
                $booking->booking_is_service = "1";
            }

            if( $request->txtbookingcovidsafe )
            {
                $booking->booking_is_covidsafe = "2";
            }
            

            $booking->save();

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'New Booking data saved successfully.'
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

    public function getviewbookingdetails(Request $request)
    {
        $garage_Owner = Auth::user();

        $data = $request->all(); // Get all input data

        //echo "<pre>"; print_r($data); die;

        $user_id = $garage_Owner->id;



        $bookingData = BookingModel::select('tbl_booking.*', 'users.name as client_name')
                                    ->leftJoin('users', 'tbl_booking.booking_customer_id', '=', 'users.id')
                                    ->where('tbl_booking.booking_garage_id',$user_id)
                                    ->findOrFail($data['bookingId']);

        //echo "<pre>"; print_r($bookingData); die;

        $booking_data = array(
            "booking_id"                =>  $bookingData["booking_id"],
            "booking_vehicle_id"        =>  $bookingData["booking_vehicle_id"],
            "booking_customer_id"       =>  $bookingData["booking_customer_id"],
            "booking_date"              =>  $bookingData["booking_date"],
            "booking_time"              =>  date("H:i", strtotime($bookingData["booking_time"])),
            "booking_date_time"         =>  date("Y-m-d H:i", strtotime($bookingData["booking_date_time"])),
            "booking_details"           =>  $bookingData["booking_details"],
            "booking_sms_template"      =>  $bookingData["booking_sms_template"],
            "client_name"               =>  $bookingData["client_name"],
            "booking_is_service"        =>  $bookingData["booking_is_service"],
            "booking_is_covidsafe"      =>  $bookingData["booking_is_covidsafe"],
        );
        return response()->json($booking_data);
    }

    public function update(Request $request)
    {
        $garage_Owner = Auth::user();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtupdatebookingvehicle'                 => 'required|string|max:10',
            'txtupdatebookingclientname'              => 'required|string|max:250',
            'ttxtupdatebookingdatetime'               => 'required|string|max:100',
            'txtupdatebookingdetails'                 => 'required|string|max:100',
            'txtupdatecovidsafenotificationtemplate'  => 'required|string',
            'txtupdatebookinguserid'                  => 'required|string|max:10'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        DB::beginTransaction(); // ✅ Begin transaction

        try {
            // Store booking record
            $booking = BookingModel::where('booking_garage_id', $garage_Owner->id)
                    ->where('booking_id', $request->txtupdatebookingid)
                    ->firstOrFail();
            $booking->booking_garage_id     = $garage_Owner->id;;
            $booking->booking_vehicle_id    = $request->txtupdatebookingvehicle;
            $booking->booking_customer_id   = $request->txtupdatebookinguserid;
            $booking->booking_date          = $request->txtupdatebookingdate;
            $booking->booking_time          = $request->txtupdatebookingtime;
            $booking->booking_date_time     = $request->ttxtupdatebookingdatetime;
            $booking->booking_details       = $request->txtupdatebookingdetails;
            $booking->booking_sms_template  = $request->txtupdatecovidsafenotificationtemplate;

            $booking->booking_is_service    = "0";
            if( $request->txtupdatebookingservice )
            {
                $booking->booking_is_service = "1";
            }

            $booking->booking_is_covidsafe = "1";
            if( $request->txtupdatebookingcovidsafe )
            {
                $booking->booking_is_covidsafe = "2";
            }
            

            $booking->save();

            DB::commit(); // ✅ Commit transaction

            return response()->json([
                'status'  => 'success',
                'message' => 'Booking data updated successfully.'
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

        $booking = BookingModel::where('booking_garage_id', $garageOwner->id)->find($request->id);
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }

        $booking->delete(); // now performs soft delete

        return response()->json(['status' => 'success', 'message' => 'Booking archived successfully.']);
    }

    public function convertdetails(Request $request)
    {
        $garageOwner = Auth::user();

        $booking = BookingModel::where('booking_garage_id', $garageOwner->id)->find($request->id);
        if (!$booking) {
            return response()->json(['status' => 'error', 'message' => 'Booking not found'], 404);
        }
        $booking->booking_is_covidsafe = "1";
        $booking->save();

        return response()->json(['status' => 'success', 'message' => 'Booking converted to Normal successfully.']);
    }
}
