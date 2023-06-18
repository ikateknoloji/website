<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function getCities()
    {
        return City::select('id', 'city')
                   ->orderByRaw("city COLLATE 'utf8mb4_turkish_ci'")
                   ->get();
    }

    public function getDistrictsByCity($city_id)
    {
        return District::where('city_id', $city_id)
                       ->select('id', 'district')
                       ->orderByRaw("district COLLATE 'utf8mb4_turkish_ci'")
                       ->get();
    }
}
