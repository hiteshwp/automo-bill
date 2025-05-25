<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Country;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $countries = Country::all(); // Fetch all countries from the database
        return view('auth.register', compact('countries'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'businessname' => 'required|string|max:255',
            'mobilenumber' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'taxnumber' => 'required|nullable|string|max:255',
            'address' => 'required|string|max:255',
            'country' => 'required|exists:tbl_countries,id',
            'state' => 'required|exists:tbl_states,id',
            'city' => 'required|exists:tbl_cities,id',
            'zip' => 'required|string|max:10',
            'website' => 'nullable|url|max:255',
            'usertype' => 'required|in:Super Admin,Garage Owner,User',
        ]);

        $user = User::create([
            'name' => $request->fullname,
            'businessname' => $request->businessname,
            'mobilenumber' => $request->mobilenumber,
            'countrycode' => $request->phonecode,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'taxnumber' => $request->taxnumber,
            'address' => $request->address,
            'country_id' => $request->country,
            'state_id' => $request->state,
            'city_id' => $request->city,
            'zip' => $request->zip,
            'website' => $request->website,
            'user_type' => $request->usaertype,
            'user_status' => "1",
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
