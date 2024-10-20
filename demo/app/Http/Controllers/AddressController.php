<?php

namespace App\Http\Controllers;

use App\Models\CityTown;
use App\Models\Province;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function showAddressPicker()
    {
        $provinces = Province::orderBy('province_name', 'asc')->get();
        return view('address', ['provinces' => $provinces]);
    }

    public function getCities($provinceName)
    {
        // Get the provinceId from the Province model using the provinceName
        $province = Province::where('province_name', $provinceName)->first();

        // If the province is found, get the cities based on provinceId
        if ($province) {
            $cities = CityTown::where('province_id', $province->province_id)
                ->orderBy('citytown_name', 'asc')
                ->get();
            return response()->json($cities);
        }

        // If no matching province is found, return an empty array or error response
        return response()->json(['error' => 'Province not found'], 404);
    }
}
