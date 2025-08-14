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

class SettingController extends Controller
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

        $setting_data = SettingModel::where("setting_garage_id", $user->id)->whereNull('deleted_at')->first();

        return view('garage-owner.setting', compact('setting_data', 'user'));
    }

    public function updateFinancialSettings(Request $request)
    {
        $user = Auth::user();

        $garageUser = User::where("user_type", "Garage Owner")->find($user->id);
        if (!$garageUser) {
            return response()->json(['status' => 'error', 'message' => 'Owner not found'], 404);
        }

        $setting_data = SettingModel::where("setting_garage_id", $user->id)->whereNull('deleted_at')->first();

       // echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'txttaxrates1'      => 'required',
            'txttaxrates2'      => 'nullable',
            'txttaxrates3'      => 'nullable',
            'txtlabourrate1'    => 'required',
            'txtlabourrate2'    => 'nullable',
            'txtlabourrate3'    => 'nullable',
            'txttaxnumber'      => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        if (!$setting_data) {
            $setting_data = new SettingModel();
            $setting_data->setting_garage_id = $user->id;
        }

        $setting_data->setting_tax_1        = $request->txttaxrates1;
        $setting_data->setting_tax_2        = $request->txttaxrates2;
        $setting_data->setting_tax_3        = $request->txttaxrates3;
        $setting_data->setting_labor_1      = $request->txtlabourrate1;
        $setting_data->setting_labor_2      = $request->txtlabourrate2;
        $setting_data->setting_labor_3      = $request->txtlabourrate3;
        $setting_data->setting_tax_number   = $request->txttaxnumber;
    
        $setting_data->save();
    
        return response()->json(['status' => 'success', 'message' => 'Financial Setting updated successfully.']);
    }

    public function updateCompanySettings(Request $request)
    {
        $user = Auth::user();

        $garageUser = User::where("user_type", "Garage Owner")->find($user->id);
        if (!$garageUser) {
            return response()->json(['status' => 'error', 'message' => 'Owner not found'], 404);
        }

        $setting_data = SettingModel::where("setting_garage_id", $user->id)->whereNull('deleted_at')->first();

        //echo "<pre>"; print_r($request->all()); die;

        $validator = Validator::make($request->all(), [
            'filepond'              => 'nullable|string',
            'txtbusinessname'       => 'required|string|max:255',
            'txtbusinesstagline'    => 'required|string|max:255',
            'txtbusinessaddress'    => 'required|string',
            'txtcompanyphone'       => 'required|string|max:20',
            'txtbusinessemail'      => 'required|email',
            'txtbusinesswebsite'    => 'nullable|string|max:255',
            'txtcspphonecode'       => 'required',
            'txtcspphoneicocode'    => 'required',
            'txtshowtaxnumber'      => 'nullable',
            'txtshowinvoicenumber'  => 'nullable',
        ], [
            'filepond.image' => 'The logo must be a valid image file.',
            'filepond.mimes' => 'Only JPG, JPEG, PNG, and GIF formats are allowed for the logo.',
            'txtbusinessname.required' => 'Please enter your business name.',
            'txtbusinessemail.email' => 'Please enter a valid email address.',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        if (!$setting_data) {
            $setting_data = new SettingModel();
            $setting_data->setting_garage_id = $user->id;
        }

        if ($request->filled('filepond')) {
            $payload = json_decode($request->filepond, true);
            if (json_last_error() !== JSON_ERROR_NONE || empty($payload['data'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => ['filepond' => ['Invalid image payload.']]
                ], 422);
            }

            $binary = base64_decode($payload['data'], true);
            if ($binary === false) {
                return response()->json([
                    'status' => 'error',
                    'message' => ['filepond' => ['Invalid base64 data.']]
                ], 422);
            }

            // Size check: 2 MB max
            if (strlen($binary) > 2048 * 1024) {
                return response()->json([
                    'status' => 'error',
                    'message' => ['filepond' => ['The logo may not be greater than 2 MB.']]
                ], 422);
            }

            // Detect real mime
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime  = finfo_buffer($finfo, $binary);
            finfo_close($finfo);

            $allowed = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/gif'  => 'gif',
                'image/webp' => 'webp',
            ];
            if (!isset($allowed[$mime])) {
                return response()->json([
                    'status' => 'error',
                    'message' => ['filepond' => ['Only JPG, JPEG, PNG, GIF, and WEBP are allowed.']]
                ], 422);
            }

            $filename = 'GO-S-'.time().'.'.$allowed[$mime];
            //$filename = 'GO-S-'.time() . '.' . $request->txtcompanylogo->extension();
            file_put_contents(public_path('uploads/company/'.$filename), $binary);
            $setting_data->setting_logo_image = $filename;
        }

        $setting_data->setting_system_name          = $request->txtbusinessname;
        $setting_data->setting_tag_line             = $request->txtbusinesstagline;
        $setting_data->setting_address              = $request->txtbusinessaddress;
        $setting_data->setting_phone_number         = $request->txtcompanyphone;
        $setting_data->setting_email                = $request->txtbusinessemail;
        $setting_data->setting_website              = $request->txtbusinesswebsite;
        $setting_data->setting_countrycode          = $request->txtcspphonecode;
        $setting_data->setting_countryisocode       = $request->txtcspphoneicocode;
        $setting_data->setting_show_tax_number      = $request->txtshowtaxnumber;
        $setting_data->setting_show_invoice_number  = $request->txtshowinvoicenumber;
    
        $setting_data->save();
    
        return response()->json(['status' => 'success', 'message' => 'Company Setting updated successfully.']);
    }
}
