<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\State;
use App\Models\City;

class LocationController extends Controller
{
    // Fetch states based on country ID
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->pluck('name', 'id');
        
        return response()->json($states);
    }

    // Fetch cities based on state ID
    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->pluck('name', 'id');

        return response()->json($cities);
    }
}
