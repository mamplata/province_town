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

    public function getCities($provinceId)
    {
        $cities = CityTown::where('province_id', $provinceId)->orderBy('citytown_name', 'asc')->get();
        return response()->json($cities);
    }
}
