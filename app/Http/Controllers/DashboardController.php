<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\BookingModel;
use App\Models\RepairOrderModel;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\InvoiceModel;
use App\Models\user;

use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;

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

    public function sendWelcomeEmail()
    {
        $toEmail = 'hitesh.wp@gmail.com'; // where you want to send
        $messageBody = 'This is test email.';

        Mail::to($toEmail)->send(new TestMail($messageBody));

        return 'Email sent successfully!';
    }

    public function garageOwnerProfile()
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();

        //echo "<pre>"; print_r($user); die;

        $countries = Country::all();
        $states = State::where("country_id",$user->country_id)->get();
        $cities = City::where("state_id",$user->state_id)->get();

        return view('garage-owner.profile', compact('user', 'countries', 'states', 'cities'));
    }

    public function updateGarageOwnerImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
            'type'  => 'required|in:Profile,Cover'
        ]);

        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $user = Auth::user();

        $file = $request->file('image');
        $filename = "GO-P-".time() . '.' . $file->getClientOriginalExtension();
        $path = public_path('uploads/profiles/garage-owner');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Delete old image if exists
        if ($request->type == 'Profile' && $user->user_profile_pic && file_exists($path . '/' . $user->user_profile_pic)) {
            unlink($path . '/' . $user->user_profile_pic);
        }
        if ($request->type == 'Cover' && $user->user_profile_background_pic && file_exists($path . '/' . $user->user_profile_background_pic)) {
            unlink($path . '/' . $user->user_profile_background_pic);
        }

        $file->move($path, $filename);

        if ($request->type == 'Profile') {
            $user->user_profile_pic = $filename;
        } else {
            $user->user_profile_background_pic = $filename;
        }

        $user->save();

        return response()->json([
            'status'  => 'success',
            'message' => ucfirst($request->type) . ' image updated successfully'
        ]);
    }

    public function updateGarageOwnerProfile(Request $request)
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $garageUser = User::where("user_type", "Garage Owner")->find($request->txtgarageownerid);
        if (!$garageUser) {
            return response()->json(['status' => 'error', 'message' => 'Owner not found'], 404);
        }

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtfullname'       => 'required',
            'txtmobile'         => 'required',
            'txteditcountry'    => 'required',
            'txteditstate'      => 'required',
            'txteditcity'       => 'required',
            'zipInput'          => 'required',
            'txtgopphonecode'   => 'required',
            'txtgopphoneicocode'=> 'required',
            'txtgarageownerid'  => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $garageUser->name           = $request->txtfullname;
        $garageUser->mobilenumber   = $request->txtmobile;
        $garageUser->country_id     = $request->txteditcountry;
        $garageUser->state_id       = $request->txteditstate;
        $garageUser->city_id        = $request->txteditcity;
        $garageUser->zip            = $request->zipInput;
        $garageUser->countrycode    = $request->txtgopphonecode;
        $garageUser->countryisocode = $request->txtgopphoneicocode;
    
        $garageUser->save();
    
        return response()->json(['status' => 'success', 'message' => 'Profile updated successfully.']);
    }

    public function updateGarageOwnerPassword(Request $request)
    {
        if (!Auth::check()) {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        if (Auth::user()->user_type !== 'Garage Owner') {
            abort(response()->json(['error' => 'Unauthenticated'], 401));
        }

        $garageUser = User::where("user_type", "Garage Owner")->find($request->txtgoppid);
        if (!$garageUser) {
            return response()->json(['status' => 'error', 'message' => 'Owner not found'], 404);
        }

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txtoldpassword'        => 'required',
            'txtnewpassword'        => 'required|min:6',
            'txtconfirmpassword'    => 'required|same:txtnewpassword'
        ], [
            'old_password.required'      => 'Please enter your current password.',
            'txtnewpassword.required'    => 'Please enter a new password.',
            'txtnewpassword.min'         => 'Your new password must be at least 6 characters long.',
            'txtconfirmpassword.required'=> 'Please confirm your new password.',
            'txtconfirmpassword.same'    => 'The confirm password must match the new password.'
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

         // Check old password
        if (!Hash::check($request->txtoldpassword, $garageUser->password)) {
            return response()->json(['status' => 'error', 'message' => array('Your current password is incorrect')]);
        }

        // Update password
        $garageUser->password = Hash::make($request->txtnewpassword);
        $garageUser->save();
    
        return response()->json(['status' => 'success', 'message' => 'New Password updated successfully.']);
    }



}
